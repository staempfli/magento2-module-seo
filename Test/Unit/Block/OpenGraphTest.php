<?php
declare(strict_types=1);
/**
 * Copyright © 2018 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */
namespace Staempfli\Seo\Test\Unit\Block;

use Staempfli\Seo\Block\OpenGraph;

/**
 * @coversDefaultClass \Staempfli\Seo\Block\OpenGraph
 */
final class OpenGraphTest extends AbstractBlockSetup
{
    /**
     * @var OpenGraph
     */
    private $block;

    public function setUp()
    {
        parent::setUp();
        $this->block = new OpenGraph($this->context, $this->adapterInterface, []);
    }

    public function testGetMetaData()
    {
        $this->assertSame('', $this->block->getMetaData());
    }
}
