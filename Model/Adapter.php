<?php
declare (strict_types=1);
/**
 * Copyright © 2017 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\Seo\Model;

class Adapter implements AdapterInterface
{
    /**
     * @var array
     */
    private $adapters;
    /**
     * @var PropertyInterface
     */
    private $property;

    public function __construct(
        PropertyInterface $property,
        array $adapters
    ) {
        $this->adapters = $adapters;
        $this->property = $property;
    }

    public function getProperty() : PropertyInterface
    {
        foreach ($this->adapters as $item) {
            /** @var AdapterInterface $item */
            $property = $item->getProperty();
            if ($property->hasData()) {
                return $property;
            }
        }
        return $this->property;
    }
}
