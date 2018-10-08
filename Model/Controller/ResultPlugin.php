<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * See LICENSE.txt for license details (http://opensource.org/licenses/osl-3.0.php).
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
     * Core store config
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @param \Magento\Framework\App\RequestInterface            $request
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->request = $request;
        $this->scopeConfig = $scopeConfig;
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

        $html = $response->getBody();
        $scripts = [];

        $startTag = '<script';
        $endTag = '</script>';

        $start = 0;
        $i = 0;
        while (false !== ($start = stripos($html, $startTag, $start))) {
            $i++;
            if ($i > 1000 ) {
                return $result;
            }

            $end = stripos($html, $endTag, $start);
            if (false === $end) {
                break;
            }

            $len = $end + strlen($endTag) - $start;
            $script = substr($html, $start, $len);

            if (false !== stripos($script, self::EXCLUDE_FLAG_PATTERN)) {
                continue;
            }

            $pos = strpos($html, $script);
            if ($pos !== false) {
                $html = substr_replace($html, '', $pos, $len);
            }

            $scripts[] = $script;
        }

        $scripts = implode(PHP_EOL, $scripts);
        if ($end = stripos($html, '</body>')) {
            $html = substr($html, 0, $end) . $scripts . substr($html, $end);
        } else {
            $html .= $scripts;
        }

        $response->setBody($html);

        return $result;
    }

    private function isEnabled()
    {
        $enabled = $this->scopeConfig->getValue(
            'mfrocketjavascript/general/enabled',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        /* check if Plumrocket AMP enabled */
        if ($enabled) {
            $isAmpRequest = $this->scopeConfig->getValue(
                'pramp/general/enabled',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );

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
}
