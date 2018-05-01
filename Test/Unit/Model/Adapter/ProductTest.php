<?php
declare(strict_types=1);
/**
 * Copyright © 2017 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */
namespace Staempfli\Seo\Test\Unit\Model\Adapter;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Staempfli\Seo\Model\Adapter\Product;
use Staempfli\Seo\Model\Property;

/**
 * @coversDefaultClass \Staempfli\Seo\Model\Adapter\Product
 */
final class ProductTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Product
     */
    private $product;

    public function setUp()
    {
        $objectManager = new ObjectManager($this);
        $propertyInterface = new Property();
        $image = $this->getMockBuilder(\Magento\Catalog\Block\Product\Image::class)
            ->disableOriginalConstructor()
            ->getMock();
        $imageBuilder = $this->getMockBuilder(\Magento\Catalog\Block\Product\ImageBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();
        $imageBuilder->expects($this->once())
            ->method('setProduct')
            ->will($this->returnValue($imageBuilder));
        $imageBuilder->expects($this->once())
            ->method('setImageId')
            ->will($this->returnValue($imageBuilder));
        $imageBuilder->expects($this->once())
            ->method('setAttributes')
            ->will($this->returnValue($imageBuilder));
        $imageBuilder->expects($this->once())
            ->method('create')
            ->will($this->returnValue($image));
        $product = $this->getMockBuilder(\Magento\Catalog\Model\Product::class)
            ->disableOriginalConstructor()
            ->getMock();
        $product->expects($this->any())
            ->method('getData')
            ->will($this->returnValue('test'));
        $product->expects($this->once())
            ->method('getProductUrl')
            ->will($this->returnValue('http://example.com/test-product'));
        $product->expects($this->once())
            ->method('getImage')
            ->will($this->returnValue('http://example.com/test-product.png'));
        $product->expects($this->once())
            ->method('getImage')
            ->will($this->returnValue('http://example.com/test-product.png'));
        $registry = $this->getMockBuilder(\Magento\Framework\Registry::class)
            ->disableOriginalConstructor()
            ->getMock();
        $registry->expects($this->once())
            ->method('registry')
            ->will($this->returnValue($product));

        $this->product = $objectManager->getObject(
            Product::class,
            [
                'propertyInterface' => $propertyInterface,
                'imageBuilder' => $imageBuilder,
                'registry' => $registry
            ]
        );
    }

    public function testGetProperty()
    {
        $result = $this->product->getProperty();
        $this->assertSame(null, $result->hasData());
    }
}
