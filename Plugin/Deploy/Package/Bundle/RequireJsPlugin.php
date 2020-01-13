<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magefan\RocketJavaScript\Plugin\Deploy\Package\Bundle;

use Magento\Deploy\Package\Bundle\RequireJs;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class RequireJsPlugin
{

    /**
     * @var string
     */
    const BUNDLING_OPTIMIZATION_ENABLED = 'mfrocketjavascript/general/enable_js_bundling_optimization';

    /**
     * @var string
     */
    const INCLUDE_IN_BUNDLING = 'mfrocketjavascript/general/included_in_bundling';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * mixed
     */
    protected $allowedFiles;

    /**
     * Construct
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Improve bundling
     */
    public function aroundAddFile(RequireJs $subject, callable $proceed, $filePath, $sourcePath, $contentType)
    {

        $jsOptimization = $this->scopeConfig->getValue(self::BUNDLING_OPTIMIZATION_ENABLED, ScopeInterface::SCOPE_STORE)
            && $this->scopeConfig->getValue('mfrocketjavascript/general/enabled', ScopeInterface::SCOPE_STORE);
        if ($jsOptimization) {
            $allowedFiles = $this->getAllowedFiles();

            $include = false;
            foreach ($allowedFiles as $allowedFile) {
                if (strpos($sourcePath, $allowedFile) !== false) {
                    $include = true;
                    break;
                }
            }

            if (!$include) {
                return true;
            }
        }
        return $proceed($filePath, $sourcePath, $contentType);
    }

    public function getAllowedFiles()
    {
        if (null === $this->allowedFiles) {
            $includeInBundling = $this->scopeConfig->getValue(self::INCLUDE_IN_BUNDLING, ScopeInterface::SCOPE_STORE);
            $allowedFiles = str_replace("\r", "\n", $includeInBundling);
            $allowedFiles = explode("\n", $allowedFiles);

            foreach ($allowedFiles as $key => $allowedFile) {
                $allowedFiles[$key] = trim($allowedFile);
                if (empty($allowedFiles[$key])) {
                    unset($allowedFiles[$key]);
                }
            }

            foreach ($allowedFiles as $allowed) {
                if (false !== strpos($allowed, '.min.js')) {
                    $allowedFiles[] = str_replace('.min.js', '.js', $allowed);
                } else {
                    $allowedFiles[] = str_replace('.js', '.min.js', $allowed);
                }
            }

            $this->allowedFiles = $allowedFiles;
        }

        return $this->allowedFiles;
    }
}
