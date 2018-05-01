<?php
declare(strict_types=1);
/**
 * Copyright © 2019 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 * @author avs@integer-net.de
 */
namespace Staempfli\Seo\Test\Unit\Block;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\StoreManagerInterface;
use Staempfli\Seo\Block\HrefLang;
use Staempfli\Seo\Service\HrefLang\AlternativeUrlService;

/**
 * @coversDefaultClass \Staempfli\Seo\Block\HrefLang
 */
final class HrefLangTest extends AbstractBlockSetup
{
    /**
     * @var HrefLang
     */
    private $block;

    public function setUp()
    {
        parent::setUp();

        $alternativeUrlSwitcherMock = $this->getMockBuilder(AlternativeUrlService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $storeMock = $this->getMockBuilder(StoreInterface::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $storeMock->method('getId')->willReturn(1);

        $storeManagerMock = $this->getMockBuilder(StoreManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $storeManagerMock->method('getStores')->willReturn([$storeMock]);
        $storeManagerMock->method('getStore')->willReturn($storeMock);

        $scopeConfigBlock = $this->getMockBuilder(ScopeConfigInterface::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $scopeConfigBlock->method('isSetFlag')->willReturn(false);

        $this->block = $this->objectManager->getObject(
            HrefLang::class,
            [
                'context' => $this->context,
                '_storeManager' => $storeManagerMock,
                '_scopeConfig' => $scopeConfigBlock,
            ]
        );
    }

    public function testGetAlternativesOnSingleStore()
    {
        $this->assertSame([], $this->block->getAlternatives());
    }
}
