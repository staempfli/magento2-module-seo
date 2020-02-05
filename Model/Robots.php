<?php
declare(strict_types=1);
/**
 * Copyright © 2018 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\Seo\Model;

use Magento\Framework\UrlInterface;
use Magento\Sitemap\Model\Sitemap;
use Magento\Store\Api\Data\WebsiteInterface;
use Magento\Store\Api\StoreResolverInterface;
use Magento\Store\Api\WebsiteRepositoryInterface;

/**
 * Class Robots
 * @package Staempfli\Seo\Model
 */
class Robots
{
    /**
     * @var Config
     */
    private $config;
    /**
     * @var Sitemap
     */
    private $sitemap;
    /**
     * @var WebsiteRepositoryInterface
     */
    private $websiteRepository;
    /**
     * @var StoreResolverInterface
     */
    private $storeResolver;

		/**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    public function __construct(
        Config $config,
        Sitemap $sitemap,
        WebsiteRepositoryInterface $websiteRepository,
        StoreResolverInterface $storeResolver,
				\Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->config = $config;
        $this->sitemap = $sitemap;
        $this->websiteRepository = $websiteRepository;
        $this->storeResolver = $storeResolver;
				$this->_storeManager = $storeManager;
    }

    public function getContent() : string
    {
        $website = $this->getCurrentWebsite();
        $content = $this->getSitemapsContent($website);
        $content[] = $this->config->getRobotsContent();

        return implode(PHP_EOL, $content);
    }

    private function getCurrentWebsite()
    {
        $websites = $this->websiteRepository->getList();
        $currentStoreId = $this->storeResolver->getCurrentStoreId();
        foreach ($websites as $website) {
            if (in_array($currentStoreId, array_keys($website->getStores()))) {
                return $website;
            }
        }
        return $this->websiteRepository->getDefault();
    }

    protected function getSitemapsContent($website) : array //@codingStandardsIgnoreLine
    {
        $data = [];
        $sitemaps = $this->sitemap
            ->getCollection()
            //->addFieldToFilter('store_id', ['in' => array_keys($website->getStores())]);
            ->addFieldToFilter('store_id', ['in' => $this->_storeManager->getStore()->getId()]);

        if (!$sitemaps) {
            return $data;
        }

        foreach ($sitemaps as $sitemap) {
						/*
            $data[] = sprintf(
                'Sitemap: %s%s%s',
                rtrim($website->getDefaultStore()->getBaseUrl(UrlInterface::URL_TYPE_DIRECT_LINK), '/'),
                $sitemap->getSitemapPath(),
                $sitemap->getSitemapFilename()
            );
						*/
						$data[] = sprintf(
                'Sitemap: %s',
                rtrim($sitemap->getSitemapUrl($sitemap->getSitemapPath(),$sitemap->getSitemapFilename()), '/')
            );
        }
        return $data;
    }
}
