<?php
declare (strict_types=1);
/**
 * Copyright © 2018 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */
namespace Staempfli\Seo\Test\Unit\Block;

use Staempfli\Seo\Block\HrefLang;

/**
 * @coversDefaultClass \Staempfli\Seo\Block\HrefLang
 */
final class HrefLangTest extends AbstractBlockSetup
{
    /**
     * @var HrefLang
     */
    private $block;

    public function setUp()
    {
        parent::setUp();
        $switcher = $this->getMockBuilder(\Magento\Store\Block\Switcher::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->block = $this->objectManager->getObject(
            HrefLang::class,
            [
                'context' => $this->context,
                'switcher' => $switcher
            ]
        );
    }

    public function testGetAlternatives()
    {
        $this->assertSame([], $this->block->getAlternatives());
    }
}
