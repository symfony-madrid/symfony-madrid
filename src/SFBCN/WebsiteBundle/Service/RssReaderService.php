<?php

namespace SFBCN\WebsiteBundle\Service;

class RssReaderService
{
    protected $feedsRss;
    private $urlResource;
    

    public function setFeedsRss($feeds)
    {
        $this->feedsRss = $feeds;
    }
    
    public function getFeedsRss()
    {
        return $this->feedsRss;
    }
    /**
     * Sets url resource, string is passed via services.yml
     * @param $url
     */
    public function setUrlResource($url)
    {
        $this->urlResource = $url;
    }

    /**
     * Reads RSS and returns item array
     * @return array
     */
    public function parseRss()
    {
        $apcKey = 'sfbcnrss_' . md5($this->urlResource);
        if (extension_loaded('apc') && apc_exists($apcKey)) {
            $rss = simplexml_load_string(apc_fetch($apcKey));
        } else {
            $rss = @simplexml_load_file($this->urlResource);
            if (!$rss) {
                return array();
            }
            apc_store($apcKey, $rss->asXML(), 3600);
        }

        return $rss->channel[0]->item;
    }
}