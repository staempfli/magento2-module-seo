<?php
declare (strict_types=1);
/**
 * Copyright © 2017 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */
namespace Staempfli\Seo\Test\Unit;

use Staempfli\Seo\Model\TwitterCard;

final class TwitterCardTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var TwitterCard
     */
    private $twitterCard;

    public function setUp()
    {
        $this->twitterCard = new TwitterCard();
    }

    public function testInvalidCardTypeException()
    {
        $this->expectException(\LogicException::class);
        $this->twitterCard->setType('invalid');
    }

    public function testSetTitle()
    {
        $result = $this->twitterCard->setTitle('test')->toHtml();
        $this->assertSame('<meta name="twitter:title" content="test" />' . PHP_EOL, $result);
    }

    public function testSetDescription()
    {
        $result = $this->twitterCard->setDescription('This is a Test')->toHtml();
        $this->assertSame('<meta name="twitter:description" content="This is a Test" />' . PHP_EOL, $result);
    }

    public function testSetImage()
    {
        $result = $this->twitterCard->setImage('http://example.org/test.jpg')->toHtml();
        $this->assertSame('<meta name="twitter:image" content="http://example.org/test.jpg" />' . PHP_EOL, $result);
    }

    public function testSetSite()
    {
        $result = $this->twitterCard->setSite('@StaempfliWeb')->toHtml();
        $this->assertSame('<meta name="twitter:site" content="@StaempfliWeb" />' . PHP_EOL, $result);
    }

    public function testSetSiteId()
    {
        $result = $this->twitterCard->setSiteId('221807590')->toHtml();
        $this->assertSame('<meta name="twitter:site:id" content="221807590" />' . PHP_EOL, $result);
    }

    public function testSetSiteIdThrowsLogicException()
    {
        $this->expectException(\LogicException::class);
        $this->twitterCard->setSiteId('@mhauri');
    }

    public function testSetCreator()
    {
        $result = $this->twitterCard->setCreator('@mhauri')->toHtml();
        $this->assertSame('<meta name="twitter:creator" content="@mhauri" />' . PHP_EOL, $result);
    }

    public function testSetCreatorId()
    {
        $result = $this->twitterCard->setCreatorId('15127622')->toHtml();
        $this->assertSame('<meta name="twitter:creator:id" content="15127622" />' . PHP_EOL, $result);
    }

    public function testSetCreatorIdThrowsLogicException()
    {
        $this->expectException(\LogicException::class);
        $this->twitterCard->setCreatorId('@mhauri');
    }
}
