<?php
namespace Magefan\RocketJavaScript\Plugin\Deploy\Package\Bundle;

use Magento\Deploy\Package\Bundle\RequireJs;

class RequireJsPlugin
{
//    protected $scopeConfig;
//
//    public function __construct(\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig)
//    {
//        $this->scopeConfig = $scopeConfig;
//    }

    public function aroundAddFile(RequireJs $subject, callable $proceed, $filePath, $sourcePath, $contentType) {

//        $jsOptimization = $this->scopeConfig->getValue('mfrocketjavascript/enable_javaScript_bundling_optimization', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
//        var_dump($jsOptimization); exit();
        return $proceed($filePath, $sourcePath, $contentType);
    }
}