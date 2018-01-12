<?php
declare (strict_types=1);
/**
 * Copyright © 2018 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */
namespace Staempfli\Seo\Test\Unit\Model;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Staempfli\Seo\Model\Robots;

/**
 * @coversDefaultClass \Staempfli\Seo\Model\Robots
 */
final class RobotsTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Robots
     */
    private $robots;

    public function setUp()
    {
        $sitemapCollection = $this->getMockBuilder(\Magento\Sitemap\Model\ResourceModel\Sitemap\Collection::class)
            ->disableOriginalConstructor()
            ->setMethods(['addFieldToFilter'])
            ->getMock();
        $sitemap = $this->getMockBuilder(\Magento\Sitemap\Model\Sitemap::class)
            ->disableOriginalConstructor()
            ->setMethods(['getCollection'])
            ->getMock();
        $sitemap->expects($this->once())->method('getCollection')->willReturn($sitemapCollection);

        $config = $this->getMockBuilder(\Staempfli\Seo\Model\Config::class)
            ->disableOriginalConstructor()
            ->getMock();
        $website = $this->getMockBuilder(\Magento\Store\Model\Website::class)
            ->disableOriginalConstructor()
            ->getMock();
        $website->expects($this->any())->method('getStores')->willReturn([]);
        $websiteRepository = $this->getMockBuilder(\Magento\Store\Api\WebsiteRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $websiteRepository->expects($this->once())->method('getList')->willReturn(['base' => $website]);
        $websiteRepository->expects($this->once())->method('getDefault')->willReturn($website);

        $storeResolver = $this->getMockBuilder(\Magento\Store\Api\StoreResolverInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $storeResolver->expects($this->once())->method('getCurrentStoreId')->willReturn('1');

        $objectManager = new ObjectManager($this);
        $this->robots = $objectManager->getObject(
            Robots::class,
            [
                'config' => $config,
                'sitemap' => $sitemap,
                'websiteRepository' => $websiteRepository,
                'storeResolver' => $storeResolver
            ]
        );
    }

    public function testGetContent()
    {
        $this->robots->getContent();
    }
}
