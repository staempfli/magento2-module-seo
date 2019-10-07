<?php
declare(strict_types=1);
/**
 * Copyright © 2017 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\Seo\Model\Adapter;

use Magento\Catalog\Block\Product\ImageBuilder;
use Magento\Catalog\Block\Product\Image;
use Staempfli\Seo\Model\AdapterInterface;
use Staempfli\Seo\Model\Property;
use Staempfli\Seo\Model\PropertyInterface;
use Magento\Framework\Registry;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Product implements AdapterInterface
{

    const STORE_NAME_PATH = 'general/store_information/name';

    /**
     * @var array
     */
    private $messageAttributes = [
      'meta_description',
      'short_description',
      'description'
    ];
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
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(
      PropertyInterface $property,
      ImageBuilder $imageBuilder,
      Registry $registry,
      ScopeConfigInterface $scopeConfig
    ) {
        $this->property = $property;
        $this->registry = $registry;
        $this->imageBuilder = $imageBuilder;
        $this->scopeConfig = $scopeConfig;
    }

    public function getProperty() : PropertyInterface
    {
        $product = $this->registry->registry('current_product');
        if ($product) {
            $this->property->addProperty('og:type', 'og:product', 'product');
            $this->property->setTitle((string) $product->getName());

            foreach ($this->messageAttributes as $messageAttribute) {
                if ($product->getData($messageAttribute)) {
                    $this->property->setDescription((string) $product->getData($messageAttribute));
                }
            }

            if ($product->getImage()) {
                $this->property->setImage((string) $this->getImage($product, 'product_base_image')->getImageUrl());
            }

            $this->property->setUrl($product->getProductUrl());
            $this->property->addProperty('product:price:amount', (string) $product->getFinalPrice(), 'product');
            $this->property->addProperty('item', $product->getData(), Property::META_DATA_GROUP);
            // Added meta tags
            $this->property->addProperty('product:retailer_item_id', $product->getSku());

            $brand = $product->getAttributeText('manufacturer') ?
              $product->getAttributeText('manufacturer') :
              $this->scopeConfig->getValue(
                self::STORE_NAME_PATH,
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
              );
            $this->property->addProperty('product:brand', $brand);

            $availability = $product->isAvailable() ? 'in stock' : 'out of stock';
            $this->property->addProperty('product:availability', $availability);
            $this->property->addProperty('product:condition', 'new');
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
