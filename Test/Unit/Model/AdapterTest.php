<?php
declare(strict_types=1);
/**
 * Copyright © 2017 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */
namespace Staempfli\Seo\Test\Unit\Model;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Staempfli\Seo\Model\Adapter;
use Staempfli\Seo\Model\Property;
use Staempfli\Seo\Model\PropertyInterface;

/**
 * @coversDefaultClass \Staempfli\Seo\Model\Adapter
 */
final class AdapterTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Adapter
     */
    private $adapter;

    public function setUp()
    {
        $productAdapter = $this->getMockBuilder(Adapter\Product::class)
            ->disableOriginalConstructor()
            ->getMock();

        $categoryAdapter = $this->getMockBuilder(Adapter\Category::class)
            ->disableOriginalConstructor()
            ->getMock();

        $pageAdapter = $this->getMockBuilder(Adapter\Page::class)
            ->disableOriginalConstructor()
            ->getMock();

        $objectManager = new ObjectManager($this);
        $this->adapter = $objectManager->getObject(
            Adapter::class,
            [
                'adapters' => [
                    'product_entity_container' => $productAdapter,
                    'category_entity_container' => $categoryAdapter,
                    'page_entity_container' => $pageAdapter
                ],
            ]
        );
    }

    public function testGetProperty()
    {
        $result = $this->adapter->getProperty();
        $this->assertSame(null, $result->hasData());
    }
}
