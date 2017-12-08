<?php
declare (strict_types=1);
/**
 * Copyright © 2017 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */
namespace Staempfli\Seo\Test\Unit;

use Staempfli\Seo\Model\OpenGraph;

final class OpenGraphTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var OpenGraph
     */
    private $openGraph;

    public function setUp()
    {
        $this->openGraph = new OpenGraph();
    }

    public function testSetTitle()
    {
        $result = $this->openGraph->setTitle('test')->toHtml();
        $this->assertSame('<meta property="og:title" content="test" />' . PHP_EOL, $result);
    }

    public function testSetDescription()
    {
        $result = $this->openGraph->setDescription('This is a Test')->toHtml();
        $this->assertSame('<meta property="og:description" content="This is a Test" />' . PHP_EOL, $result);
    }

    public function testSetImage()
    {
        $result = $this->openGraph->setImage('http://example.org/test.jpg')->toHtml();
        $this->assertSame('<meta property="og:image" content="http://example.org/test.jpg" />' . PHP_EOL, $result);
    }
}
