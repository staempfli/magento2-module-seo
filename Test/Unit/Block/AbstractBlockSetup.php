<?php
/**
 * Copyright © 2018 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */
namespace Staempfli\Seo\Test\Unit\Block;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Staempfli\Seo\Model\AdapterInterface;
use Staempfli\Seo\Model\Config;
use Staempfli\Seo\Model\Property;

abstract class AbstractBlockSetup extends \PHPUnit\Framework\TestCase
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var \Magento\Framework\View\Element\Template\Context|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $context;
    /**
     * @var \Staempfli\Seo\Model\Config|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $config;
    /**
     * @var \Staempfli\Seo\Model\AdapterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $adapterInterface;
    /**
     * @var \Staempfli\Seo\Model\PropertyInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $propertyInterface;

    public function setUp()
    {
        $this->objectManager = new ObjectManager($this);
        $this->context = $this->getMockBuilder(\Magento\Framework\View\Element\Template\Context::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->config = $this->getMockBuilder(Config::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->propertyInterface = new Property();

        $this->adapterInterface = $this->getMockBuilder(AdapterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->adapterInterface->expects($this->any())->method('getProperty')->willReturn($this->propertyInterface);
    }
}
