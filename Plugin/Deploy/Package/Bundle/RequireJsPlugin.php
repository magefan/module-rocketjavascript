<?php
namespace Magefan\RocketJavaScript\Plugin\Deploy\Package\Bundle;

use Magento\Deploy\Package\Bundle\RequireJs;

class RequireJsPlugin
{
    protected $scopeConfig;

    public function __construct(\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function aroundAddFile(RequireJs $subject, callable $proceed, $filePath, $sourcePath, $contentType) {

        $jsOptimization = $this->scopeConfig->getValue('mfrocketjavascript/general/enable_javaScript_bundling_optimization', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if ($jsOptimization) {
            $includeInBundling = $this->scopeConfig->getValue('mfrocketjavascript/general/included_in_bundling', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            $allowedFiles = str_replace("\r","\n", $includeInBundling);
            $allowedFiles = explode("\n", $allowedFiles);

            foreach ($allowedFiles  as $key => $allowedFile) {
                $allowedFiles[$key] = trim($allowedFile);
                if (empty($allowedFiles[$key])) {
                    unset($allowedFiles[$key]);
                }
            }

            foreach ($allowedFiles as $allowed) {
                $allowedFiles[] = str_replace('.min.js', '.js', $allowed);
            }

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
}