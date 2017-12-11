<?php
declare (strict_types=1);
/**
 * Copyright © 2017 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\Seo\Model\Adapter;

use Magento\Catalog\Block\Product\ImageBuilder;
use Magento\Catalog\Block\Product\Image;
use Staempfli\Seo\Model\AdapterInterface;
use Staempfli\Seo\Model\PropertyInterface;
use \Magento\Framework\Registry;

class Product implements AdapterInterface
{
    /**
     * @var PropertyInterface
     */
    private $property;
    /**
     * @var Registry
     */
    private $registry;
    /**
     * @var ImageBuilder
     */
    private $imageBuilder;

    public function __construct(
        PropertyInterface $property,
        ImageBuilder $imageBuilder,
        Registry $registry
    ) {
        $this->property = $property;
        $this->registry = $registry;
        $this->imageBuilder = $imageBuilder;
    }

    public function getProperty() : PropertyInterface
    {
        $product = $this->registry->registry('current_product');
        if ($product) {
            $this->property
                ->addProperty('og:type', 'og:product', 'product')
                ->setTitle($product->getName());

            $this->property->setDescription($product->getDescription());
            if ($product->getShortDescription()) {
                $this->property->setDescription($product->getShortDescription());
            }

            if ($product->getImage()) {
                $this->property->setImage($this->getImage($product, 'product_base_image')->getImageUrl());
            }

            $this->property
                ->setUrl($product->getProductUrl())
                ->addProperty('product:price:amount', (string) $product->getFinalPrice(), 'product');
        }
        return $this->property;
    }

    private function getImage(\Magento\Catalog\Model\Product $product, string $imageId, array $attributes = []) : Image
    {
        return $this->imageBuilder->setProduct($product)
            ->setImageId($imageId)
            ->setAttributes($attributes)
            ->create();
    }
}
