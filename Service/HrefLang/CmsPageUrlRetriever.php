<?php

namespace Staempfli\Seo\Service\HrefLang;

use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Cms\Model\ResourceModel\Page as PageResource;
use Magento\CmsUrlRewrite\Model\CmsPageUrlPathGenerator;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\Store;
use Staempfli\Seo\Api\CmsPageUrlRetrieverInterface;

class CmsPageUrlRetriever implements CmsPageUrlRetrieverInterface
{
    /**
     * @var PageRepositoryInterface
     */
    private $pageRepository;
    /**
     * @var CmsPageUrlPathGenerator
     */
    private $cmsPageUrlPathGenerator;
    /**
     * @var PageResource
     */
    private $pageResource;

    public function __construct(
        PageRepositoryInterface $pageRepository,
        CmsPageUrlPathGenerator $cmsPageUrlPathGenerator,
        PageResource $pageResource
    ) {
        $this->pageRepository = $pageRepository;
        $this->cmsPageUrlPathGenerator = $cmsPageUrlPathGenerator;
        $this->pageResource = $pageResource;
    }

    /**
     * @param int $identifier The page ID
     * @param Store $store
     * @return string
     */
    public function getUrl($identifier, $store)
    {
        try {
            $page = $this->pageRepository->getById($identifier);
            $pageId = $this->pageResource->checkIdentifier($page->getIdentifier(), $store->getId());
            $storePage = $this->pageRepository->getById($pageId);
            $path = $this->cmsPageUrlPathGenerator->getUrlPath($storePage);
            return $store->getBaseUrl() . $path;
        } catch (LocalizedException $e) {
            return '';
        }
    }
}
