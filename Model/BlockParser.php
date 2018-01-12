<?php
declare (strict_types=1);
/**
 * Copyright © 2018 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\Seo\Model;

use Magento\Cms\Api\BlockRepositoryInterface;

class BlockParser
{
    /**
     * @var BlockRepositoryInterface
     */
    private $blockRepository;

    public function __construct(
        BlockRepositoryInterface $blockRepository
    ) {
        $this->blockRepository = $blockRepository;
    }

    public function getBlockContentById(int $blockId) : string
    {
        try {
            $cmsBlock = $this->blockRepository->getById($blockId);
            return html_entity_decode($cmsBlock->getData('content')) ?? ''; //@codingStandardsIgnoreLine
        } catch (\Exception $e) {
            return '';
        }
    }
}
