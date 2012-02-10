<?php

namespace SFBCN\WebsiteBundle\Service;

class RssReaderService
{
    /**
     * @var array
     */
    protected $feedsRss;

    /**
     * @var string
     */
    private $rawFeed;

    /**
     * @var string
     */
    private $feedName;

    /**
     * Sets configured RSS Feeds (@see services.yml)
     * @param array $feeds
     */
    public function setFeedsRss($feeds)
    {
        $this->feedsRss = $feeds;
    }
    
    /**
     * Gets injected RSS Feeds
     * @return array
     */
    public function getFeedsRss()
    {
        return $this->feedsRss;
    }

    /**
     * @param string $rawFeed
     */
    public function setRawFeed($rawFeed)
    {
        $this->rawFeed = $rawFeed;
        return $this;
    }

    /**
     * @return string
     */
    public function getRawFeed()
    {
        return $this->rawFeed;
    }

    /**
     * @param string $feedName
     */
    public function setFeedName($feedName)
    {
        $this->feedName = $feedName;
        return $this;
    }

    /**
     * @return string
     */
    public function getFeedName()
    {
        return $this->feedName;
    }

    /**
     * Reads RSS and returns item array. Info is stored in APC during an hour to increase speed
     * @return array
     */
    public function parseRss()
    {
        $apcKey = 'sfbcnrss_' . md5($this->getFeedName());
        if (extension_loaded('apc') && apc_exists($apcKey)) {
            $rss = simplexml_load_string(apc_fetch($apcKey));
        } else {
            /**
             * Symfony.es did not work with simplexml_load_file in PHP5.3.6
             */
            $rss = simplexml_load_string($this->getRawFeed());
            if (!$rss) {
                return array();
            }
            apc_store($apcKey, $rss->asXML(), 3600);
        }

        return $rss->channel[0]->item;
    }
}