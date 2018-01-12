<?php
declare (strict_types=1);
/**
 * Copyright © 2018 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */
namespace Staempfli\Seo\Test\Unit\Block;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Staempfli\Seo\Block\HrefLang;

/**
 * @coversDefaultClass \Staempfli\Seo\Block\HrefLang
 */
final class HrefLangTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var HrefLang
     */
    private $block;

    public function setUp()
    {
        $objectManager = new ObjectManager($this);
        $this->block = $objectManager->getObject(
            HrefLang::class
        );
    }

    public function testGetAlternatives()
    {
        $this->markTestSkipped();
    }
}
