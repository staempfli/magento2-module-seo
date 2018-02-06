<?php

namespace Staempfli\Seo\Service\HrefLang;

use Magento\Store\Model\Store;
use Staempfli\Seo\Api\UrlRetrieverInterface;

class CmsPageUrlRetriever implements UrlRetrieverInterface
{
    /**
     * @param string|int $identifier
     * @param Store $store
     * @return string
     */
    public function getUrl($identifier, $store)
    {
        return 'test';
    }
}