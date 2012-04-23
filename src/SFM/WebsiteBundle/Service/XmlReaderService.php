<?php

namespace SFM\WebsiteBundle\Service;

class XmlReaderService
{

    /**
     * @var array
     */
    private $feedsXml;

    /**
     * @var string
     */
    private $rawFeed;

    /**
     * @var string
     */
    private $feedName;

    /**
     * (@see services.yml)
     * @param array $feeds
     */
    public function __construct($feeds = null)
    {
        if (null !== $feeds)
        {
            $this->setFeedsXml($feeds);
        }
    }

    /**
     * Sets configured RSS Feeds
     * @param array $feeds
     */
    public function setFeedsXml($feeds)
    {
        $this->feedsXml = $feeds;
    }

    /**
     * Gets injected RSS Feeds
     * @return array
     */
    public function getFeedsXml()
    {
        return $this->feedsXml;
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
     * Actually gets feed contents, either from apc or network. Contents is stored 1 hour if everything is ok and 1 minute an empty string if there is an error
     * @param string $url
     * @return string
     */
    public function getFeedContents($url)
    {
        $apcKey = 'sfmrss_' . md5($this->getFeedName());
        $rssString = false;
        if (extension_loaded('apc'))
        {
            if (function_exists('apc_exists'))
            {
                if (apc_exists($apcKey))
                {
                    $rssString = apc_fetch($apcKey);
                } else
                {
                    $rssString = file_get_contents($url);
                    if (!$rssString)
                    {
                        apc_store($apcKey, '', 60);
                    } else
                    {
                        apc_store($apcKey, $rssString, 3600);
                    }
                }
            }
        }
        if (!$rssString)
        {
            $rssString = file_get_contents($url);
        }

        return $rssString;
    }


    /**
     * Reads RSS and returns item array.
     * @return array
     */
    public function parseXml()
    {
        $rssString = $this->getRawFeed();
        if (empty($rssString))
        {
            return array();
        } else
        {
            return simplexml_load_string($rssString);
        }
    }

}
