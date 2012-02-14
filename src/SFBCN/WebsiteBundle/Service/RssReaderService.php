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
        if (extension_loaded('apc')) {
            if (apc_exists($apcKey)) {
                $rss = simplexml_load_string(apc_fetch($apcKey));
            } else {
                $rss = $this->getRSSInfo($this->urlResource);

                if (!$rss) {
                    apc_store($apcKey, array(), 3600);
                } else {
                    apc_store($apcKey, $rss->asXML(), 3600);
                }
            }
        } else {
            $rss = $this->getRSSInfo($this->urlResource);
        }

        if (!$rss) {
            return array();
        } else {
            return $rss->channel[0]->item;
        }
    }

    /**
     * Connects to RSS Url resource and obtains info
     * @param string $url
     * @return \SimpleXMLElement
     */
    private function getRSSInfo($url)
    {
        /**
         * Symfony.es did not work with simplexml_load_file in PHP5.3.6
         */
        return simplexml_load_string(file_get_contents($url));
    }
}