<?php

namespace Staempfli\Seo\Service\HrefLang;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\Category;
use Magento\CatalogUrlRewrite\Model\CategoryUrlPathGenerator;
use Magento\Store\Model\Store;
use Staempfli\Seo\Api\CategoryUrlRetrieverInterface;

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
    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        CategoryUrlPathGenerator $categoryUrlPathGenerator,
        \Magento\Framework\Registry $registry
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->categoryUrlPathGenerator = $categoryUrlPathGenerator;
        $this->registry = $registry;
    }

    /**
     * @param int $identifier the category ID
     * @param Store $store
     * @return string
     */
    public function getUrl($identifier, $store)
    {
        /** @var Category $category */
        $category = $this->registry->registry('category');
        if(!$category) {
            $category = $this->categoryRepository->get($identifier, $store->getId());
        }
        $path = $this->categoryUrlPathGenerator->getUrlPathWithSuffix($category);
        return $store->getBaseUrl() . $path;
    }
}
