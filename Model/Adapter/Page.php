<?php
declare (strict_types=1);
/**
 * Copyright © 2017 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\Seo\Model\Adapter;

use Magento\Cms\Model\Page as CmsPage;
use Magento\Framework\UrlInterface;
use Staempfli\Seo\Model\AdapterInterface;
use Staempfli\Seo\Model\PropertyInterface;

class Page implements AdapterInterface
{
    /**
     * @var PropertyInterface
     */
    private $property;
    /**
     * @var CmsPage
     */
    private $page;
    /**
     * @var UrlInterface
     */
    private $url;

    public function __construct(
        CmsPage $page,
        UrlInterface $url,
        PropertyInterface $property
    ) {
        $this->property = $property;
        $this->page = $page;
        $this->url = $url;
    }

    public function getProperty() : PropertyInterface
    {
        if ($this->page->getId()) {
            $this->property
                ->setTitle($this->page->getTitle())
                ->setDescription(strip_tags(str_replace(["\r", "\n"], '', $this->page->getContent())))
                ->setUrl($this->url->getUrl($this->page->getIdentifier()));
        }
        return $this->property;
    }
}
