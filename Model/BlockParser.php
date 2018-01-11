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
        $data = $this->blockRepository->getById($blockId)->toArray();
        return html_entity_decode($data['content']) ?? ''; //@codingStandardsIgnoreLine
    }
}
