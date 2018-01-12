<?php
declare (strict_types=1);
/**
 * Copyright © 2017 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\Seo\Model\Adapter;

use Magento\Cms\Model\Page as CmsPage;
use Magento\Cms\Model\Template\FilterProvider;
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
    /**
     * @var FilterProvider
     */
    private $filterProvider;

    public function __construct(
        CmsPage $page,
        UrlInterface $url,
        FilterProvider $filterProvider,
        PropertyInterface $property
    ) {
        $this->property = $property;
        $this->page = $page;
        $this->url = $url;
        $this->filterProvider = $filterProvider;
    }

    public function getProperty() : PropertyInterface
    {
        if ($this->page->getId()) {
            $this->property
                ->setTitle((string) $this->page->getTitle())
                ->setDescription((string) $this->filterProvider->getBlockFilter()->filter($this->page->getContent()))
                ->setUrl((string) $this->url->getUrl($this->page->getIdentifier()));
        }
        return $this->property;
    }
}
