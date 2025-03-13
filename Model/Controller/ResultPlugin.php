<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magefan\RocketJavaScript\Model\Controller;

use Magento\Framework\App\Response\Http as ResponseHttp;

/**
 * Plugin for processing relocation of javascript
 */
class ResultPlugin
{
    const EXCLUDE_FLAG_PATTERN = 'data-rocketjavascript="false"';

    /**
     * Request
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * @var \Magefan\RocketJavaScript\Model\Config
     */
    protected $config;

    /**
     * @var bool
     */
    protected $allowedOnPage;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * ResultPlugin constructor.
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magefan\RocketJavaScript\Model\Config $config
     * @param \Magento\Store\Model\StoreManagerInterface|null $storeManager
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magefan\RocketJavaScript\Model\Config $config,
        \Magento\Store\Model\StoreManagerInterface $storeManager = null
    ) {
        $this->request = $request;
        $this->config = $config;

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $this->storeManager = $storeManager ?: $objectManager->get(
            \Magento\Store\Model\StoreManagerInterface::class
        );
    }

    /**
     * @param \Magento\Framework\Controller\ResultInterface $subject
     * @param callable $proceed
     * @param ResponseHttp $response
     * @return \Magento\Framework\Controller\ResultInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundRenderResult(
        \Magento\Framework\Controller\ResultInterface $subject,
        \Closure $proceed,
        ResponseHttp $response
    ) {
        $result = $proceed($response);
        if (PHP_SAPI === 'cli' || $this->request->isXmlHttpRequest() || !$this->isEnabled()) {
            return $result;
        }

        if (!$this->isAllowedOnPage()) {
            return $result;
        }

        $ignoredStrings = $this->config->getIgnoreJavaScript() ?: '';
        $ignoredStrings = explode("\n", str_replace("\r", "\n", $ignoredStrings));
        foreach ($ignoredStrings as $key => $ignoredString) {
            $ignoredString = trim($ignoredString);
            if (!$ignoredString) {
                unset($ignoredStrings[$key]);
            } else {
                $ignoredStrings[$key] = $ignoredString;
            }
        }

        $html = $response->getBody();
        $scripts = [];

        $startTag = '<script';
        $endTag = '</script>';

        $start = 0;
        $i = 0;
        while (false !== ($start = stripos($html, $startTag, $start))) {
            $i++;
            if ($i > 1000) {
                return $result;
            }

            $end = stripos($html, $endTag, $start);
            if (false === $end) {
                break;
            }

            $len = $end + strlen($endTag) - $start;
            $script = substr($html, $start, $len);

            if (false !== stripos($script, self::EXCLUDE_FLAG_PATTERN)) {
                $start++;
                continue;
            }

            if (false !== stripos($script, 'application/ld+json')) {
                $start++;
                continue;
            }

            foreach ($ignoredStrings as $ignoredString) {
                if (false !== stripos($script, $ignoredString)) {
                    $start++;
                    continue 2;
                }
            }

            $html = str_replace($script, '', $html);
            $scripts[] = $script;
        }

        $scripts = implode(PHP_EOL, $scripts);
        $end = stripos($html, '</body>');
        if ($end !== false) {
            $html = substr($html, 0, $end) . $scripts . substr($html, $end);
        } else {
            $html .= $scripts;
        }

        $response->setBody($html);

        return $result;
    }

    private function isEnabled()
    {
        $enabled = $this->config->isEnabled() && $this->config->isDeferredEnabled();


        if ($enabled) {

            /* check if Amasty AMP enabled */
            if ($this->request->getParam('is_amp')) {
                return false;
            }

            /* check if Plumrocket AMP enabled */
            $isAmpRequest = $this->config->isAmpRequest();

            if ($isAmpRequest) {
                /* We know that using objectManager is not a not a good practice,
                but if Plumrocket_AMP is not installed on your magento instance
                you'll get error during di:compile */
                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $isAmpRequest = $objectManager->get('\Plumrocket\Amp\Helper\Data')
                    ->isAmpRequest();
            }

            $enabled = !$isAmpRequest;
        }

        return $enabled;
    }

    /**
     * @return bool
     */
    private function isAllowedOnPage()
    {
        if (null !== $this->allowedOnPage) {
            return $this->allowedOnPage;
        }
        $this->allowedOnPage = false;

        $spPages = $this->config->getDisallowedPages();
        $spPages = explode("\n", str_replace("\r", "\n", $spPages));

        foreach ($spPages as $key => $path) {
            $spPages[$key] = trim($spPages[$key]);
            if (empty($spPages[$key])) {
                unset($spPages[$key]);
            }
        }
        $baseUrl = trim($this->storeManager->getStore()->getBaseUrl(), '/');
        $baseUrl = str_replace('/index.php', '', $baseUrl);

        $currentUrl = $this->storeManager->getStore()->getCurrentUrl();
        $currentUrl = explode('?', $currentUrl);
        $currentUrl = trim($currentUrl[0], '/');
        foreach (['index.php', '.php', '.html'] as $end) {
            $el = mb_strlen($end);
            $cl = mb_strlen($currentUrl);
            if (mb_strrpos($currentUrl, $end) == $cl - $el) {
                $currentUrl = mb_substr($currentUrl, 0, $cl - $el);
            }
        }
        $currentUrl = str_replace('/index.php', '', $currentUrl);
        $currentUrl = trim($currentUrl, '/');
        foreach ($spPages as $key => $path) {
            $path = trim($path, '/');

            if (mb_strlen($path)) {
                if ('*' == $path[0]) {
                    $subPath = trim($path, '*/');
                    if (mb_strlen($currentUrl) - mb_strlen($subPath) === mb_strrpos($currentUrl, $subPath)) {
                        $this->allowedOnPage = true;
                        break;
                    }
                }

                if ('*' == $path[mb_strlen($path) - 1]) {
                    if (0 === mb_strpos($currentUrl, $baseUrl . '/' . trim($path, '*/'))) {
                        $this->allowedOnPage = true;
                        break;
                    }
                }
                if ($currentUrl == $baseUrl . '/' . trim($path, '/')) {
                    $this->allowedOnPage = true;
                    break;
                }
            } else {
                //homepage

                if ($currentUrl == $baseUrl) {
                    $this->allowedOnPage = true;
                    break;
                }
            }
        }

        return $this->allowedOnPage = !$this->allowedOnPage;
    }
}
