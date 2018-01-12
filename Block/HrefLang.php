<?php
declare (strict_types=1);
/**
 * Copyright © 2018 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\Seo\Block;

use Magento\Framework\View\Element\Template;
use Magento\Store\Block\Switcher;

class HrefLang extends Template
{
    /**
     * @var Switcher
     */
    private $switcher;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        Switcher $switcher,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->switcher = $switcher;
    }

    public function getAlternatives()
    {
        $data = [];
        foreach ((array) $this->switcher->getStores() as $store) {
            if ($store->getId() !== $this->switcher->getCurrentStoreId()) {
                $data[substr($store->getLocaleCode(), 0, 2)] = $store->getCurrentUrl(false);
            }
        }
        return $data;
    }
}
