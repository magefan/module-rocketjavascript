<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

declare(strict_types=1);

namespace Magefan\RocketJavaScript\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\View\Asset\Config as MagentoConfig;

class Config
{
    /**
     * General config
     */
    public const XML_PATH_EXTENSION_ENABLED = 'mfrocketjavascript/general/enabled';
    public const XML_PATH_MERGE_FILES = 'mfrocketjavascript/general/merge_files';
    public const XML_PATH_MINIFY_FILES = 'mfrocketjavascript/general/minify_files';

    /**
     * Deferred JavaScript config
     */
    public const XML_PATH_DEFERRED_ENABLED = 'mfrocketjavascript/deferred_javascript/enabled';
    public const XML_PATH_DEFERRED_DISALLOWED_PAGES = 'mfrocketjavascript/deferred_javascript/disallowed_pages_for_deferred_js';
    public const XML_PATH_DEFERRED_IGNORE_JAVASCRIPT = 'mfrocketjavascript/deferred_javascript/ignore_deferred_javascript_with';

    /**
     * JavaScript Bundling config
     */
    public const  XML_PATH_JAVASCRIPT_BUNDLING_ENABLED = 'mfrocketjavascript/javascript_bundling/enabled';
    public const  XML_PATH_JAVASCRIPT_BUNDLING_OPTIMIZATION_ENABLED = 'mfrocketjavascript/javascript_bundling/enable_js_bundling_optimization';
    public const  XML_PATH_JAVASCRIPT_BUNDLING_INCLUDED_IN_BUNDLING = 'mfrocketjavascript/javascript_bundling/included_in_bundling';

    /**
     * Plumrocket AMP config
     */
    public const  XML_PATH_PLUMROCKET_AMP_ENABLED = 'pramp/general/enabled';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * Config constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Retrieve true if module is enabled
     *
     * @param string|null $storeId
     * @return bool
     */
    public function isEnabled(?string $storeId = null): bool
    {
        return (bool)$this->getConfig(self::XML_PATH_EXTENSION_ENABLED, $storeId);
    }

    /**
     * Retrieve true if deferred is enabled
     *
     * @param string|null $storeId
     * @return bool
     */
    public function isDeferredEnabled(?string $storeId = null): bool
    {
        return (bool)$this->getConfig(self::XML_PATH_DEFERRED_ENABLED, $storeId);
    }

    /**
     * Retrieve Disallowed Pages
     *
     * @param string|null $storeId
     * @return string
     */
    public function getDisallowedPages(?string $storeId = null): string
    {
        return (string)$this->getConfig(self::XML_PATH_DEFERRED_DISALLOWED_PAGES, $storeId);
    }

    /**
     * Retrieve Ignore JS
     *
     * @param string|null $storeId
     * @return string
     */
    public function getIgnoreJavaScript(?string $storeId = null): string
    {
        return (string)$this->getConfig(self::XML_PATH_DEFERRED_IGNORE_JAVASCRIPT, $storeId);
    }

    /**
     * Retrieve true if JS bundling is enabled
     *
     * @param string|null $storeId
     * @return bool
     */
    public function isBundlingEnabled(?string $storeId = null): bool
    {
        return (bool)$this->getConfig(MagentoConfig::XML_PATH_JS_BUNDLING, $storeId);
    }

    /**
     * Retrieve true if bundling optimization is enabled
     * @return bool
     */
    public function isBundlingOptimizationEnabled(): bool
    {
        return (bool)$this->getConfig(self::XML_PATH_JAVASCRIPT_BUNDLING_OPTIMIZATION_ENABLED);
    }

    /**
     * Retrieve included in bundling JS
     * @return string
     */
    public function getIncludedInBundling(): string
    {
        return (string)$this->getConfig(self::XML_PATH_JAVASCRIPT_BUNDLING_INCLUDED_IN_BUNDLING);
    }

    /**
     * Retrieve true if amp enabled
     *
     * @param string|null $storeId
     * @return bool
     */
    public function isAmpRequest(?string $storeId = null): bool
    {
        return (bool)$this->getConfig(self::XML_PATH_PLUMROCKET_AMP_ENABLED, $storeId);
    }

    /**
     * Retrieve store config value
     *
     * @param string $path
     * @param string|null $storeId
     * @return mixed
     */
    public function getConfig(string $path, ?string $storeId = null)
    {
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE, $storeId);
    }
}
