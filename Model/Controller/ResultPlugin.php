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

        $patterns = [
            'js' => '#(\s*<!--(\[if[^\n]*>)?\s*(<script.*</script>)+\s*(<!\[endif\])?-->)|(\s*<script.*</script>)#isU',
        ];

        $jsHtml = [];

        foreach ($patterns as $pattern) {
            $matches = [];
            $success = preg_match_all($pattern, $html, $matches);
            if ($success) {
                foreach ($matches[0] as $i => $js) {
                    if (strpos($js, self::EXCLUDE_FLAG_PATTERN) !== false) {
                        unset($matches[0][$i]);
                    } else {
                        $jsHtml[] = $matches[0][$i];
                    }
                }

                $html = str_replace($matches[0], '', $html);
            }
        }

        $jsHtml = implode($jsHtml);
        if ($end = strrpos($html, '</body>')) {
            $html = substr($html, 0, $end) . $jsHtml . substr($html, $end);
        } else {
            $html .= $jsHtml;
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
