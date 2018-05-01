<?php
declare(strict_types=1);
/**
 * Copyright © 2017 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */
namespace Staempfli\Seo\Test\Unit\Model;

use Staempfli\Seo\Model\Property;

/**
 * @coversDefaultClass \Staempfli\Seo\Model\Property
 */
final class PropertyTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Property
     */
    private $property;

    /**
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
    private $filterProvider;

    public function setUp()
    {
        $this->filterProvider = $this->getMockBuilder(\Magento\Cms\Model\Template\FilterProvider::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->property = new Property($this->filterProvider);
    }

    public function testSetPrefix()
    {
        $result = $this->property->setPrefix('og:')->setTitle('test')->toHtml();
        $this->assertSame('<meta name="og:title" content="test" />' . PHP_EOL, $result);
    }

    public function testSetMetaAttributeName()
    {
        $result = $this->property->setMetaAttributeName('property')->setTitle('test')->toHtml();
        $this->assertSame('<meta property="title" content="test" />' . PHP_EOL, $result);
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

    public function testSetDescriptionGetReducedTo200Chars()
    {
        $result = $this->property->setDescription('Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.')->toHtml();
        $this->assertSame('<meta name="description" content="Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolo ..." />' . PHP_EOL, $result);
    }

    public function testSetImage()
    {
        $result = $this->property->setImage('http://example.org/test.jpg')->toHtml();
        $this->assertSame('<meta name="image" content="http://example.org/test.jpg" />' . PHP_EOL, $result);
    }

    public function testSetImageAlt()
    {
        $result = $this->property->setImageAlt('Test')->toHtml();
        $this->assertSame('<meta name="image:alt" content="Test" />' . PHP_EOL, $result);
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
