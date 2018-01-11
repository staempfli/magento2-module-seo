<?php
declare (strict_types=1);
/**
 * Copyright © 2018 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\Seo\Block;

use Magento\Store\Block\Switcher;

class HrefLang extends Switcher
{
    public function getAlternatives()
    {
        $data = [];
        foreach ((array) $this->getStores() as $store) {
            if ($store->getId() !== $this->getCurrentStoreId()) {
                $data[substr($store->getLocaleCode(), 0, 2)] = $store->getCurrentUrl(false);
            }
        }
        return $data;
    }
}
