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
     * @return RssReaderService
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
     * @return RssReaderService
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
     * Reads RSS and returns item array. Info is stored in APC during an hour to increase
     * speed
     *
     * @return array
     */
    public function parseRss()
    {
        $apcKey = 'sfbcnrss_' . md5($this->getFeedName());
        if (extension_loaded('apc')) {
            if (apc_exists($apcKey)) {
                $rss = simplexml_load_string(apc_fetch($apcKey));
            } else {
                $rss = $this->getRSSInfo();
                if (!$rss) {
                    apc_store($apcKey, array(), 3600);
                } else {
                    apc_store($apcKey, $rss->asXML(), 3600);
                }
            }
        } else {
            $rss = $this->getRSSInfo();
        }

        if (!$rss) {
            return array();
        } else {
            return $rss->channel[0]->item;
        }
    }

    /**
     * Connects to RSS Url resource and obtains info
     * @return \SimpleXMLElement
     */
    private function getRSSInfo()
    {
        /**
         * Symfony.es did not work with simplexml_load_file in PHP5.3.6
         */
        return simplexml_load_string($this->getRawFeed());
    }
}