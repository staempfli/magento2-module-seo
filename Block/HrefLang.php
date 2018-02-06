<?php
declare (strict_types=1);
/**
 * Copyright © 2018 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 * @author avs@integer-net.de
 */

namespace Staempfli\Seo\Block;

use Magento\Framework\View\Element\Template;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\Store;

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
        foreach ($this->_storeManager->getStores() as $store) {
            if ($this->isCurrentStore($store)) {
                continue;
            }
            if ($url = $this->getStoreUrl($store)) {
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
}
