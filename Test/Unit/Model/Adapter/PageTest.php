<?php
declare (strict_types=1);
/**
 * Copyright © 2017 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */
namespace Staempfli\Seo\Test\Unit\Model\Adapter;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Staempfli\Seo\Model\Adapter\Page;
use Staempfli\Seo\Model\Property;
use Staempfli\Seo\Model\PropertyInterface;

/**
 * @coversDefaultClass \Staempfli\Seo\Model\Adapter\Page
 */
final class PageTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Page
     */
    private $page;

    public function setUp()
    {
        $objectManager = new ObjectManager($this);

        $page = $this->getMockBuilder(\Magento\Cms\Model\Page::class)
            ->disableOriginalConstructor()
            ->getMock();
        $page->expects($this->once())->method('getId')->willReturn('1');
        $page->expects($this->once())->method('getTitle')->willReturn('Test');
        $page->expects($this->once())->method('getContent')->willReturn('Test Content');
        $page->expects($this->once())->method('getIdentifier')->willReturn('test');

        $urlInterface = $this->getMockBuilder(\Magento\Framework\UrlInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $blockFilter = $this->getMockBuilder(\Zend_Filter_Interface::class)
            ->disableOriginalConstructor()
            ->setMethods(['filter'])
            ->getMock();
        $blockFilter->expects($this->once())->method('filter')->willReturn('Test Content');
        $filterProvider = $this->getMockBuilder(\Magento\Cms\Model\Template\FilterProvider::class)
            ->disableOriginalConstructor()
            ->getMock();
        $filterProvider->expects($this->once())->method('getBlockFilter')->willReturn($blockFilter);

        $propertyInterface = $this->getMockBuilder(PropertyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->page = $objectManager->getObject(
            Page::class,
            [
                'page' => $page,
                'urlInterface' => $urlInterface,
                'filterProvider' => $filterProvider,
                'propertyInterface' => $propertyInterface
            ]
        );
    }

    public function testGetProperty()
    {
        $result = $this->page->getProperty();
        $this->assertSame(null, $result->hasData());
    }
}
