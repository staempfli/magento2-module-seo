<?php

namespace Staempfli\Seo\Service\HrefLang;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\Category;
use Magento\CatalogUrlRewrite\Model\CategoryUrlPathGenerator;
use Magento\Store\Model\Store;
use Staempfli\Seo\Api\CategoryUrlRetrieverInterface;
use Staempfli\Seo\Api\UrlRetrieverInterface;

class CategoryUrlRetriever implements CategoryUrlRetrieverInterface
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;
    /**
     * @var CategoryUrlPathGenerator
     */
    private $categoryUrlPathGenerator;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        CategoryUrlPathGenerator $categoryUrlPathGenerator
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->categoryUrlPathGenerator = $categoryUrlPathGenerator;
    }

    /**
     * @param int $identifier the category ID
     * @param Store $store
     * @return string
     */
    public function getUrl($identifier, $store)
    {
        /** @var Category $category */
        $category = $this->categoryRepository->get($identifier, $store->getId());
        $path = $this->categoryUrlPathGenerator->getUrlPathWithSuffix($category);
        return $store->getBaseUrl() . $path;
    }
}