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
                ['value' => TwitterCard::CARD_TYPE_SUMMARY, 'label' => __('Summary')],
                ['value' => TwitterCard::CARD_TYPE_SUMMARY_LARGE_IMAGE, 'label' => __('Summary with large Image')],
                ['value' => TwitterCard::CARD_TYPE_APP, 'label' => __('App')],
                ['value' => TwitterCard::CARD_TYPE_PLAYER, 'label' => __('Player')],
            ];
        }
        return $this->_options;
    }
}
