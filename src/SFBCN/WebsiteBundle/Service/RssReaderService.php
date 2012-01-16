<?php

namespace SFBCN\WebsiteBundle\Service;

class RssReaderService
{
    private $urlResource;

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
        $rss = @simplexml_load_file($this->urlResource);
        /**
         * @todo Decide how to handle this exception
         */
        if (!$rss) {
            return array();
        }

        return $rss->channel[0]->item;
    }
}