<?php
declare (strict_types=1);
/**
 * Copyright © 2017 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\Seo\Model\Adapter;

use Staempfli\Seo\Model\AdapterInterface;
use \Magento\Framework\Registry;
use Staempfli\Seo\Model\PropertyInterface;

class Category implements AdapterInterface
{
    /**
     * @var Registry
     */
    private $registry;
    /**
     * @var PropertyInterface
     */
    private $property;

    public function __construct(
        PropertyInterface $property,
        Registry $registry
    ) {
        $this->registry = $registry;
        $this->property = $property;
    }

    public function getProperty() : PropertyInterface
    {
        /**
         * @var $category \Magento\Catalog\Model\Category
         */
        $category = $this->registry->registry('current_category');
        if ($category) {
            $this->property
                ->setTitle($category->getName())
                ->setUrl($category->getUrl());

            if ($category->getMetaDescription()) {
                $this->property->setDescription($category->getMetaDescription());
            } elseif ($category->getShortDescription()) {
                $this->property->setDescription($category->getShortDescription());
            } else {
                $this->property->setDescription($category->getDescription());
            }

            if ($category->getImageUrl()) {
                $this->property->setImage($category->getImageUrl());
            }
        }
        return $this->property;
    }
}
