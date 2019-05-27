<?php

namespace Staempfli\Seo\Service\HrefLang;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;
use Magento\CatalogUrlRewrite\Model\ProductUrlPathGenerator;
use Magento\Store\Model\Store;
use Staempfli\Seo\Api\ProductUrlRetrieverInterface;

class ProductUrlRetriever implements ProductUrlRetrieverInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var ProductUrlPathGenerator
     */
    private $productUrlPathGenerator;
    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductUrlPathGenerator $productUrlPathGenerator,
        \Magento\Framework\Registry $registry
    ) {
        $this->productRepository = $productRepository;
        $this->productUrlPathGenerator = $productUrlPathGenerator;
        $this->registry = $registry;
    }

    /**
     * @param int $identifier the product ID
     * @param Store $store
     * @return string
     */
    public function getUrl($identifier, $store)
    {
        /** @var Product $product */
        $product = $this->registry->registry('product');
        if (!$product) {
            $product = $this->productRepository->getById($identifier, false, $store->getId());
        }
        $path = $this->productUrlPathGenerator->getUrlPathWithSuffix($product, $store->getId());
        return $store->getBaseUrl() . $path;
    }
}
