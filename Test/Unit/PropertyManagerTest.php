<?php
declare (strict_types=1);
/**
 * Copyright © 2017 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */
namespace Staempfli\Seo\Test\Unit;

use Staempfli\Seo\Model\PropertyManager;

final class PropertyManagerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var PropertyManager
     */
    private $propertyManager;

    public function setUp()
    {
        $this->propertyManager = new PropertyManager();
    }

    public function testSetTitle()
    {
        $result = $this->propertyManager->setTitle('test')->toHtml();
        $this->assertSame('<meta name="title" content="test" />' . PHP_EOL, $result);
    }

    public function testSetDescription()
    {
        $result = $this->propertyManager->setDescription('This is a Test')->toHtml();
        $this->assertSame('<meta name="description" content="This is a Test" />' . PHP_EOL, $result);
    }

    public function testSetDescriptionWithUmlaut()
    {
        $result = $this->propertyManager->setDescription('Während Adam lacht, jagen zwölf Boxkämpfer Eva quer über den großen Sylter Deich - für satte 12.345.667,89 €uro')->toHtml();
        $this->assertSame('<meta name="description" content="W&auml;hrend Adam lacht, jagen zw&ouml;lf Boxk&auml;mpfer Eva quer &uuml;ber den gro&szlig;en Sylter Deich - f&uuml;r satte 12.345.667,89 &euro;uro" />' . PHP_EOL, $result);
    }

    public function testSetImage()
    {
        $result = $this->propertyManager->setImage('http://example.org/test.jpg')->toHtml();
        $this->assertSame('<meta name="image" content="http://example.org/test.jpg" />' . PHP_EOL, $result);
    }

    public function testInvalidImageFormatException()
    {
        $this->expectException(\LogicException::class);
        $this->propertyManager->setImage('invalid.tiff');
    }

    public function testSetUrl()
    {
        $result = $this->propertyManager->setUrl('http://example.org')->toHtml();
        $this->assertSame('<meta name="url" content="http://example.org" />' . PHP_EOL, $result);
    }

    public function testInvalidUrlException()
    {
        $this->expectException(\LogicException::class);
        $this->propertyManager->setUrl('gugus.com');
    }
}
