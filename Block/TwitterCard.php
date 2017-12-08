<?php
declare (strict_types=1);
/**
 * Copyright © 2017 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\Seo\Block;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Staempfli\Seo\Model\AdapterInterface;
use Staempfli\Seo\Model\Config;

class TwitterCard implements ArgumentInterface, SeoBlockInterface
{
    /**
     * @var Config
     */
    private $config;
    /**
     * @var AdapterInterface
     */
    private $adapter;

    public function __construct(
        Config $config,
        AdapterInterface $adapter
    ) {
        $this->config = $config;
        $this->adapter = $adapter;
    }

    /**
     * @return string
     */
    public function getMetaData()
    {
        $property = $this->adapter->getProperty();
        return $property
            ->setPrefix('twitter:')
            ->addProperty('card', $this->config->getDefaultTwitterCardType())
            ->addProperty('site', $this->config->getDefaultTwitterCardSite())
            ->addProperty('creator', $this->config->getDefaultTwitterCardCreator())
            ->toHtml();
    }
}
