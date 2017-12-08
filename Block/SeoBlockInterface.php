<?php
declare (strict_types=1);
/**
 * Copyright © 2017 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */
namespace Staempfli\Seo\Block;

interface SeoBlockInterface
{
    /**
     * @return string
     */
    public function getMetaData();
}
