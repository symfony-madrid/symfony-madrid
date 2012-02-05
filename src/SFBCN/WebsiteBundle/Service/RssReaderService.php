<?php

namespace SFBCN\WebsiteBundle\Service;

class RssReaderService
{
    protected $feedsRss;
    private $urlResource;

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
     * Sets url resource to be processed in parseRSS
     * @param string $url
     */
    public function setUrlResource($url)
    {
        $this->urlResource = $url;
    }

    /**
     * Reads RSS and returns item array. Info is stored in APC during an hour to increase speed
     * @return array
     */
    public function parseRss()
    {
        $apcKey = 'sfbcnrss_' . md5($this->urlResource);
        if (extension_loaded('apc') && apc_exists($apcKey)) {
            $rss = simplexml_load_string(apc_fetch($apcKey));
        } else {
            /**
             * Symfony.es did not work with simplexml_load_file in PHP5.3.6
             */
            $rss = simplexml_load_string(file_get_contents($this->urlResource));
            if (!$rss) {
                return array();
            }
            apc_store($apcKey, $rss->asXML(), 3600);
        }

        return $rss->channel[0]->item;
    }
}