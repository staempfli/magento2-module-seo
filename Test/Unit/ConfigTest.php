<?php
declare (strict_types=1);
/**
 * Copyright © 2017 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */
namespace Staempfli\Seo\Test\Unit;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Staempfli\Seo\Model\Config;

/**
 * @coversDefaultClass \Staempfli\Seo\Model\Config
 */
final class ConfigTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Config
     */
    private $config;

    public function setUp()
    {
        $scopeConfigInterface = $this->getMockBuilder(ScopeConfigInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $objectManager = new ObjectManager($this);
        $this->config = $objectManager->getObject(
            Config::class,
            [
                'scopeConfigInterface' => $scopeConfigInterface,
            ]
        );
    }

    public function testGetGoogleSiteVerificationCode()
    {
        $result = $this->config->getGoogleSiteVerificationCode();
        $this->assertSame("", $result);
    }

    public function testGetBingSiteVerificationCode()
    {
        $result = $this->config->getBingSiteVerificationCode();
        $this->assertSame("", $result);
    }

    public function testGetPinterestSiteVerificationCode()
    {
        $result = $this->config->getPinterestSiteVerificationCode();
        $this->assertSame("", $result);
    }

    public function testGetYandexSiteVerificationCode()
    {
        $result = $this->config->getYandexSiteVerificationCode();
        $this->assertSame("", $result);
    }

    public function testGetDefaultTwitterCardCreator()
    {
        $result = $this->config->getDefaultTwitterCardCreator();
        $this->assertSame("", $result);
    }

    public function testGetDefaultTwitterCardSite()
    {
        $result = $this->config->getDefaultTwitterCardSite();
        $this->assertSame("", $result);
    }

    public function testGetDefaultTwitterCardType()
    {
        $result = $this->config->getDefaultTwitterCardType();
        $this->assertSame("", $result);
    }
}
