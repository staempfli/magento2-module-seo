<?php
declare (strict_types=1);
/**
 * Copyright © 2018 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */
namespace Staempfli\Seo\Test\Unit\Controller;

use Staempfli\Seo\Controller\Index\Index;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Staempfli\Seo\Model\Robots;

/**
 * @coversDefaultClass \Staempfli\Seo\Controller\Index\Index
 */
final class IndexTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Index
     */
    private $controller;

    public function setUp()
    {
        $objectManager = new ObjectManager($this);
        $robots = $this->getMockBuilder(Robots::class)
            ->disableOriginalConstructor()
            ->getMock();
        $context = $this->getMockBuilder(\Magento\Framework\App\Action\Context::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->controller = $objectManager->getObject(
            Index::class,
            [
                'robots' => $robots,
                'context' => $context
            ]
        );
    }

    public function testExecute()
    {
        $this->assertSame(null, $this->controller->getActionFlag());
    }
}
