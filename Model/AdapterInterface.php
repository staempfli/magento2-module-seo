<?php
declare(strict_types=1);
/**
 * Copyright © 2017 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\Seo\Model;

interface AdapterInterface
{
    /**
     * @return \Staempfli\Seo\Model\Property
     */
    public function getProperty();
}
