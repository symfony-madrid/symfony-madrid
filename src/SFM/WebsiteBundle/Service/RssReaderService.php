<?php

namespace SFM\WebsiteBundle\Service;

use SFM\WebsiteBundle\Service\XmlReaderService;

class RssReaderService extends XmlReaderService
{

    /**
     * Reads RSS and returns item array.
     * @return array
     */
    public function parseRss()
    {
        $rssString = $this->getRawFeed();
        if (empty($rssString))
        {
            return array();
        } else
        {
            $rss = simplexml_load_string($rssString);

            return $rss->channel[0]->item;
        }
    }

}
