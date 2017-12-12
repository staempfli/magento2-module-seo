<?php
declare (strict_types=1);
/**
 * Copyright © 2017 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */
namespace Staempfli\Seo\Test\Unit\Adapter;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Staempfli\Seo\Model\Adapter\Product;

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
        $this->product = $objectManager->getObject(
            Product::class
        );
    }

    public function testGetProperty()
    {
        $result = $this->product->getProperty();
        $this->assertSame(null, $result->hasData());
    }
}
