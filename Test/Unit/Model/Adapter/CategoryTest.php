<?php
declare (strict_types=1);
/**
 * Copyright © 2017 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */
namespace Staempfli\Seo\Test\Unit\Model\Adapter;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Staempfli\Seo\Model\Adapter\Category;

/**
 * @coversDefaultClass \Staempfli\Seo\Model\Adapter\Category
 */
final class CategoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Category
     */
    private $category;

    public function setUp()
    {
        $objectManager = new ObjectManager($this);
        $this->category = $objectManager->getObject(
            Category::class
        );
    }

    public function testGetProperty()
    {
        $result = $this->category->getProperty();
        $this->assertSame(null, $result->hasData());
    }
}
