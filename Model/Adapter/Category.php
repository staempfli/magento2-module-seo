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
                ->setTitle((string) $category->getName())
                ->setUrl((string) $category->getUrl());

            if ($category->getMetaDescription()) {
                $this->property->setDescription((string) $category->getMetaDescription());
            } elseif ($category->getShortDescription()) {
                $this->property->setDescription((string) $category->getShortDescription());
            } else {
                $this->property->setDescription((string) $category->getDescription());
            }

            if ($category->getImageUrl()) {
                $this->property->setImage((string) $category->getImageUrl());
            }
        }
        return $this->property;
    }
}
