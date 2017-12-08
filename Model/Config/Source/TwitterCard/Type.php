<?php
declare (strict_types=1);
/**
 * Copyright © 2017 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */
namespace Staempfli\Seo\Model\Config\Source\TwitterCard;

use Magento\Framework\Option\ArrayInterface;
use Staempfli\Seo\Model\Property\TwitterCard;

/**
 * Class Behavior
 * @package Staempfli\CommerceImport\Model\Config\Source
 */
class Type implements ArrayInterface
{
    const CARD_TYPE_SUMMARY = 'summary';
    const CARD_TYPE_SUMMARY_LARGE_IMAGE = 'summary_large_image';
    const CARD_TYPE_APP = 'app';
    const CARD_TYPE_PLAYER = 'player';

    /**
     * Options array
     *
     * @var array
     */
    protected $_options;
    /**
     * Return options array
     *
     * @return array
     */
    public function toOptionArray()
    {
        if (!$this->_options) {
            $this->_options = [
                ['value' => self::CARD_TYPE_SUMMARY, 'label' => __('Summary')],
                ['value' => self::CARD_TYPE_SUMMARY_LARGE_IMAGE, 'label' => __('Summary with large Image')],
                ['value' => self::CARD_TYPE_APP, 'label' => __('App')],
                ['value' => self::CARD_TYPE_PLAYER, 'label' => __('Player')],
            ];
        }
        return $this->_options;
    }
}
