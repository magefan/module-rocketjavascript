<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

declare(strict_types=1);

namespace Magefan\RocketJavaScript\Plugin\Frontend\Magento\Theme\Controller\Result;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\Layout;
use Magento\Store\Model\ScopeInterface;
use Magefan\RocketJavaScript\Model\Config;

class JsFooterPlugin
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param \Magento\Theme\Controller\Result\JsFooterPlugin $subject
     * @param \Closure $proceed
     * @param Layout $argumentSubject
     * @param Layout $result
     * @param ResponseInterface $httpResponse
     * @return Layout|mixed
     */
    public function aroundAfterRenderResult(
        \Magento\Theme\Controller\Result\JsFooterPlugin $subject,
        \Closure $proceed,
        Layout $argumentSubject,
        Layout $result,
        ResponseInterface $httpResponse
    ) {
        $jsRjOptimization =
            $this->scopeConfig->isSetFlag(Config::XML_PATH_DEFERRED_ENABLED, ScopeInterface::SCOPE_STORE) &&
            $this->scopeConfig->isSetFlag(Config::XML_PATH_EXTENSION_ENABLED, ScopeInterface::SCOPE_STORE);

        return $jsRjOptimization
            ? $result
            : $proceed($argumentSubject, $result, $httpResponse);
    }
}
