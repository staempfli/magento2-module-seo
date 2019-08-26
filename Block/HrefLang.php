<?php
declare(strict_types=1);
/**
 * Copyright © 2018 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 * @author avs@integer-net.de
 */

namespace Staempfli\Seo\Block;

use Magento\Framework\View\Element\Template;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\Group;
use Magento\Store\Model\Store;
use Magento\Store\Model\Website;

class HrefLang extends Template
{
    /**
     * @var \Staempfli\Seo\Service\HrefLang\AlternativeUrlService
     */
    private $alternativeUrlService;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Staempfli\Seo\Service\HrefLang\AlternativeUrlService $alternativeUrlService,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->alternativeUrlService = $alternativeUrlService;
    }

    /**
     * @return array in format [en_us => $url] or [en => $url]
     */
    public function getAlternatives()
    {
        $data = [];
        foreach ($this->getStores() as $store) {
            if ($store->isActive() == false) {
                continue;
            }
            
            $url = $this->getStoreUrl($store);
            if ($url) {
                $data[$this->getLocaleCode($store)] = $url;
            }
        }
        return $data;
    }

    /**
     * @param Store $store
     * @return string
     */
    private function getStoreUrl($store)
    {
        return $this->alternativeUrlService->getAlternativeUrl($store);
    }

    /**
     * @param StoreInterface $store
     * @return bool
     */
    private function isCurrentStore($store)
    {
        return $store->getId() == $this->_storeManager->getStore()->getId();
    }

    /**
     * @param StoreInterface $store
     * @return string
     */
    private function getLocaleCode($store)
    {
        $localeCode = $this->_scopeConfig->getValue('seo/hreflang/locale_code', 'stores', $store->getId())
            ?: $this->_scopeConfig->getValue('general/locale/code', 'stores', $store->getId());
        return str_replace('_', '-', strtolower($localeCode));
    }

    /**
     * @return Store[]
     */
    private function getStores()
    {
        if ($this->_scopeConfig->isSetFlag('seo/hreflang/same_website_only')) {
            return $this->getSameWebsiteStores();
        }
        return $this->_storeManager->getStores();
    }

    /**
     * @return Store[]
     */
    private function getSameWebsiteStores()
    {
        $stores = [];
        /** @var Website $website */
        $website = $this->_storeManager->getWebsite();
        foreach ($website->getGroups() as $group) {
            /** @var Group $group */
            foreach ($group->getStores() as $store) {
                $stores[] = $store;
            }
        }
        return $stores;
    }
}
