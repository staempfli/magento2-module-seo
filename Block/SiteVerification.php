<?php
declare (strict_types=1);
/**
 * Copyright © 2017 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\Seo\Block;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Staempfli\Seo\Model\PropertyInterface;
use Staempfli\Seo\Model\Config;

class SiteVerification implements ArgumentInterface, SeoBlockInterface
{
    const GOOLE_SITE_VERIFICATION = 'google-site-verification';
    const MSVALIDATE_01 = 'msvalidate.01';
    const P_DOMAIN_VERIFY = 'p:domain_verify';
    const YANDEX_VERIFICATION = 'yandex-verification';

    /**
     * @var Config
     */
    private $config;
    /**
     * @var PropertyInterface
     */
    private $property;

    public function __construct(
        Config $config,
        PropertyInterface $property
    ) {
        $this->config = $config;
        $this->property = $property;
    }

    public function getMetaData() : string
    {
        $this->property->addProperty(self::GOOLE_SITE_VERIFICATION, $this->config->getGoogleSiteVerificationCode());
        $this->property->addProperty(self::MSVALIDATE_01, $this->config->getBingSiteVerificationCode());
        $this->property->addProperty(self::P_DOMAIN_VERIFY, $this->config->getPinterestSiteVerificationCode());
        $this->property->addProperty(self::YANDEX_VERIFICATION, $this->config->getYandexSiteVerificationCode());
        return $this->property->toHtml();
    }
}
