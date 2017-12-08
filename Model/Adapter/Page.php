<?php
declare (strict_types=1);
/**
 * Copyright © 2017 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\Seo\Model\Adapter;

use Staempfli\Seo\Model\AdapterInterface;
use Staempfli\Seo\Model\PropertyInterface;

class Page implements AdapterInterface
{
    /**
     * @var PropertyInterface
     */
    private $property;

    public function __construct(
        PropertyInterface $property
    ) {
        $this->property = $property;
    }

    public function getProperty() : PropertyInterface
    {
        return $this->property;
    }
}
