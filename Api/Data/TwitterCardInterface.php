<?php
declare (strict_types=1);
/**
 * Copyright © 2017 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\Seo\Api\Data;

/**
 * Interface TwitterCardInterface
 * @package Staempfli\Seo\Api\Data
 * @api
 */
interface TwitterCardInterface extends PropertyInterface
{
    /**
     * @param string $type
     * @return $this
     */
    public function setType(string $type);

    /**
     * @param string $site
     * @return $this
     */
    public function setSite(string $site);

    /**
     * @param string $siteId
     * @return $this
     */
    public function setSiteId(string $siteId);

    /**
     * @param string $creator
     * @return $this
     */
    public function setCreator(string $creator);

    /**
     * @param string $creatorId
     * @return $this
     */
    public function setCreatorId(string $creatorId);
}
