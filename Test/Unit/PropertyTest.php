<?php
declare (strict_types=1);
/**
 * Copyright © 2017 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */
namespace Staempfli\Seo\Test\Unit;

use Staempfli\Seo\Model\Property;

final class PropertyTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Property
     */
    private $property;

    public function setUp()
    {
        $this->property = new Property();
    }

    public function testSetTitle()
    {
        $result = $this->property->setTitle('test')->toHtml();
        $this->assertSame('<meta name="title" content="test" />' . PHP_EOL, $result);
    }

    public function testSetDescription()
    {
        $result = $this->property->setDescription('This is a Test')->toHtml();
        $this->assertSame('<meta name="description" content="This is a Test" />' . PHP_EOL, $result);
    }

    public function testSetDescriptionWithUmlaut()
    {
        $result = $this->property->setDescription('Während Adam lacht, jagen zwölf Boxkämpfer Eva quer über den großen Sylter Deich - für satte 12.345.667,89 €uro')->toHtml();
        $this->assertSame('<meta name="description" content="W&auml;hrend Adam lacht, jagen zw&ouml;lf Boxk&auml;mpfer Eva quer &uuml;ber den gro&szlig;en Sylter Deich - f&uuml;r satte 12.345.667,89 &euro;uro" />' . PHP_EOL, $result);
    }

    public function testSetImage()
    {
        $result = $this->property->setImage('http://example.org/test.jpg')->toHtml();
        $this->assertSame('<meta name="image" content="http://example.org/test.jpg" />' . PHP_EOL, $result);
    }

    public function testInvalidImageFormatException()
    {
        $this->expectException(\LogicException::class);
        $this->property->setImage('invalid.tiff');
    }

    public function testSetUrl()
    {
        $result = $this->property->setUrl('http://example.org')->toHtml();
        $this->assertSame('<meta name="url" content="http://example.org" />' . PHP_EOL, $result);
    }

    public function testInvalidUrlException()
    {
        $this->expectException(\LogicException::class);
        $this->property->setUrl('gugus.com');
    }

    public function testGetPropertyReturnsEmptyStringWhenNotSet()
    {
        $result = $this->property->getProperty('foo');
        $this->assertSame('', $result);
    }

    public function testGetPropertyReturnsCorrectValue()
    {
        $this->property->addProperty('foo', 'bar');
        $result = $this->property->getProperty('foo');
        $this->assertSame('bar', $result);
    }

    public function testToHtmlResetsProperties()
    {
        $this->property->addProperty('foo', 'bar')->toHtml();
        $result = $this->property->getProperty('foo');
        $this->assertSame('', $result);
    }

    public function testHasDataWithoutProperties()
    {
        $result = $this->property->hasData();
        $this->assertSame(false, $result);
    }

    public function testHasDataWithProperties()
    {
        $this->property->addProperty('foo', 'bar');
        $result = $this->property->hasData();
        $this->assertSame(true, $result);
    }

    public function testRemoveProperty()
    {
        $this->property->addProperty('foo', 'bar');
        $this->property->removeProperty('foo');
        $result = $this->property->hasData();
        $this->assertSame(false, $result);
    }
}
