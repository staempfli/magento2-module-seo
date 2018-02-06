<?php

namespace Staempfli\Seo\Service\HrefLang;

use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Store\Model\Store;

class AlternativeUrlService
{
    /**
     * @var CmsPageUrlRetriever
     */
    private $cmsPageUrlRetriever;
    /**
     * @var HttpRequest
     */
    private $request;
    /**
     * @var CategoryUrlRetriever
     */
    private $categoryUrlRetriever;

    public function __construct(
        CmsPageUrlRetriever $cmsPageUrlRetriever,
        CategoryUrlRetriever $categoryUrlRetriever,
        HttpRequest $request
    ) {
        $this->cmsPageUrlRetriever = $cmsPageUrlRetriever;
        $this->request = $request;
        $this->categoryUrlRetriever = $categoryUrlRetriever;
    }

    /**
     * @param Store $store
     * @return string
     */
    public function getAlternativeUrl($store)
    {
        switch ($this->request->getFullActionName())
        {
            case 'catalog_category_view':
                return $this->categoryUrlRetriever->getUrl($this->request->getParam('id'), $store);
        }
        return $this->cmsPageUrlRetriever->getUrl('identifier', $store);
    }
}