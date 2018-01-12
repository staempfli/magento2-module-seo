<?php
declare (strict_types=1);
/**
 * Copyright © 2017 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\Seo\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Config
 * @package Staempfli\Seo\Model
 */
class Config
{
    const XML_PATH_SEO_GOOGLE_SITE_VERIFICATION_CODE = 'seo/verifications/google';
    const XML_PATH_SEO_BING_SITE_VERIFICATION_CODE = 'seo/verifications/bing';
    const XML_PATH_SEO_PINTEREST_SITE_VERIFICATION_CODE = 'seo/verifications/pinterest';
    const XML_PATH_SEO_YANDEX_SITE_VERIFICATION_CODE = 'seo/verifications/yandex';
    const XML_PATH_SEO_TWITTER_DEFAULT_TYPE = 'seo/twitter_card/type';
    const XML_PATH_SEO_TWITTER_DEFAULT_SITE = 'seo/twitter_card/site';
    const XML_PATH_SEO_TWITTER_DEFAULT_CREATOR = 'seo/twitter_card/creator';
    const XML_PATH_ROBOTS_CONTENT = 'seo/robots/content';
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * Config constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    public function getGoogleSiteVerificationCode() : string
    {
        return $this->getConfigValue(self::XML_PATH_SEO_GOOGLE_SITE_VERIFICATION_CODE);
    }

    public function getBingSiteVerificationCode() : string
    {
        return $this->getConfigValue(self::XML_PATH_SEO_BING_SITE_VERIFICATION_CODE);
    }

    public function getPinterestSiteVerificationCode() : string
    {
        return $this->getConfigValue(self::XML_PATH_SEO_PINTEREST_SITE_VERIFICATION_CODE);
    }

    public function getYandexSiteVerificationCode() : string
    {
        return $this->getConfigValue(self::XML_PATH_SEO_YANDEX_SITE_VERIFICATION_CODE);
    }

    public function getDefaultTwitterCardType() : string
    {
        return $this->getConfigValue(self::XML_PATH_SEO_TWITTER_DEFAULT_TYPE);
    }

    public function getDefaultTwitterCardSite() : string
    {
        return $this->getConfigValue(self::XML_PATH_SEO_TWITTER_DEFAULT_SITE);
    }

    public function getDefaultTwitterCardCreator() : string
    {
        return $this->getConfigValue(self::XML_PATH_SEO_TWITTER_DEFAULT_CREATOR);
    }

    public function getRobotsContent() : string
    {
        return $this->getConfigValue(self::XML_PATH_ROBOTS_CONTENT);
    }

    private function getConfigValue(string $configPath) : string
    {
        $result = $this->scopeConfig->getValue(
            $configPath,
            ScopeInterface::SCOPE_STORE
        );
        return $result ?? '';
    }
}
