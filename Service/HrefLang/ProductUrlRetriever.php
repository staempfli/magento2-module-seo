<?php

namespace Staempfli\Seo\Service\HrefLang;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;
use Magento\CatalogUrlRewrite\Model\ProductUrlPathGenerator;
use Magento\Store\Model\Store;
use Staempfli\Seo\Api\UrlRetrieverInterface;

class ProductUrlRetriever implements UrlRetrieverInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var ProductUrlPathGenerator
     */
    private $productUrlPathGenerator;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductUrlPathGenerator $productUrlPathGenerator
    ) {
        $this->productRepository = $productRepository;
        $this->productUrlPathGenerator = $productUrlPathGenerator;
    }

    /**
     * @param int $identifier the product ID
     * @param Store $store
     * @return string
     */
    public function getUrl($identifier, $store)
    {
        /** @var Product $product */
        $product = $this->productRepository->getById($identifier, false, $store->getId());
        $path = $this->productUrlPathGenerator->getUrlPathWithSuffix($product, $store->getId());
        return $store->getBaseUrl() . $path;
    }
}