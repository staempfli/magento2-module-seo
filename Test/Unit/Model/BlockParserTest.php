<?php
declare (strict_types=1);
/**
 * Copyright © 2018 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */
namespace Staempfli\Seo\Test\Unit\Model;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Staempfli\Seo\Model\BlockParser;

/**
 * @coversDefaultClass \Staempfli\Seo\Model\BlockParser
 */
final class BlockParserTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var BlockParser
     */
    private $blockParser;
    /**
     * @var \Magento\Cms\Api\BlockRepositoryInterface
     */
    private $blockRepositoryInterface;

    public function setUp()
    {
        $objectManager = new ObjectManager($this);
        $this->blockRepositoryInterface = $this->getMockForAbstractClass(
            'Magento\Cms\Api\BlockRepositoryInterface',
            [],
            '',
            false
        );

        $this->blockParser = $objectManager->getObject(
            BlockParser::class,
            [
                'BlockRepositoryInterface' => $this->blockRepositoryInterface
            ]
        );
    }

    public function testGetBlockContentById()
    {
        $this->markTestSkipped();
    }
}
