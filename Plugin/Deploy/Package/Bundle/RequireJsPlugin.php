<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magefan\RocketJavaScript\Plugin\Deploy\Package\Bundle;

use Magento\Deploy\Package\Bundle\RequireJs;
use Magefan\RocketJavaScript\Model\Config;

class RequireJsPlugin
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * mixed
     */
    protected $allowedFiles;

    /**
     * RequireJsPlugin constructor.
     * @param Config $config
     */
    public function __construct(
        Config $config
    ) {
        $this->config = $config;
    }

    /**
     * Improve bundling
     */
    public function aroundAddFile(RequireJs $subject, callable $proceed, $filePath, $sourcePath, $contentType)
    {
        $jsOptimization = $this->config->isEnabled() && $this->config->isBundlingOptimizationEnabled();

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
            $includeInBundling = $this->config->getIncludedInBundling();
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
