<?php
declare(strict_types=1);
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
    private $cmsBlock;
    private $blockRepository;

    public function setUp()
    {
        $this->cmsBlock = $this->getMockBuilder(\Magento\Cms\Model\Block::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->blockRepository = $this->getMockBuilder(\Magento\Cms\Api\BlockRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->blockParser = new BlockParser($this->blockRepository);
    }

    public function testGetBlockContentById()
    {
        $this->blockRepository->expects($this->once())
            ->method('getById')
            ->with(1)
            ->willReturn($this->cmsBlock);
        $this->cmsBlock->expects($this->once())
            ->method('getData')
            ->willReturn('test');
        $this->assertSame('test', $this->blockParser->getBlockContentById(1));
    }

    public function testGetBlockContentByIdShowsEmptyStringWhenThrowsException()
    {
        $this->blockRepository->expects($this->once())
            ->method('getById')
            ->with(2)
            ->willThrowException(new \Exception('Exception'));
        $this->assertSame('', $this->blockParser->getBlockContentById(2));
    }
}
