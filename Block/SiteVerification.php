<?php
declare(strict_types=1);
/**
 * Copyright © 2017 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\Seo\Block;

use Magento\Framework\View\Element\Template;
use Staempfli\Seo\Model\PropertyInterface;
use Staempfli\Seo\Model\Config;

class SiteVerification extends Template implements SeoBlockInterface
{
    const ACTIVE_PATH = 'seo/verifications/active';
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
        \Magento\Framework\View\Element\Template\Context $context,
        Config $config,
        PropertyInterface $property,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->config = $config;
        $this->property = $property;
    }

    public function getMetaData()
    {
        if (!$this->isActive()) {
            return '';
        }

        $this->property->addProperty(self::GOOLE_SITE_VERIFICATION, $this->config->getGoogleSiteVerificationCode());
        $this->property->addProperty(self::MSVALIDATE_01, $this->config->getBingSiteVerificationCode());
        $this->property->addProperty(self::P_DOMAIN_VERIFY, $this->config->getPinterestSiteVerificationCode());
        $this->property->addProperty(self::YANDEX_VERIFICATION, $this->config->getYandexSiteVerificationCode());
        return $this->property->toHtml();
    }

    private function isActive()
    {
        return $this->config->isActive(self::ACTIVE_PATH);
    }
}
