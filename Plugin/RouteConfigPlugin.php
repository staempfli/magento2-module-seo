<?php

namespace Staempfli\Seo\Plugin;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Route\Config as Subject;

class RouteConfigPlugin
{
    public function afterGetModulesByFrontName(Subject $subject, $result, $frontName)
    {
        if ($frontName === 'robots') {
            return [0 => 'Staempfli_Seo'];
        }
        return $result;
    }
}
