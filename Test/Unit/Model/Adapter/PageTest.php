<?php
declare (strict_types=1);
/**
 * Copyright © 2017 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */
namespace Staempfli\Seo\Test\Unit\Model\Adapter;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Staempfli\Seo\Model\Adapter\Page;

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
        $this->page = $objectManager->getObject(
            Page::class
        );
    }

    public function testGetProperty()
    {
        $result = $this->page->getProperty();
        $this->assertSame(null, $result->hasData());
    }
}
