<?php

namespace SFM\WebsiteBundle\Service;

class RssReaderService {

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
     * (@see services.yml)
     * @param array $feeds
     */
    public function __construct($feeds = null) {
        if (null !== $feeds) {
            $this->setFeedsRss($feeds);
        }
    }

    /**
     * Sets configured RSS Feeds
     * @param array $feeds
     */
    public function setFeedsRss($feeds) {
        $this->feedsRss = $feeds;
    }

    /**
     * Gets injected RSS Feeds
     * @return array
     */
    public function getFeedsRss() {
        return $this->feedsRss;
    }

    /**
     * @param string $rawFeed
     * @return RssReaderService
     */
    public function setRawFeed($rawFeed) {
        $this->rawFeed = $rawFeed;
        return $this;
    }

    /**
     * @return string
     */
    public function getRawFeed() {
        return $this->rawFeed;
    }

    /**
     * @param string $feedName
     * @return RssReaderService
     */
    public function setFeedName($feedName) {
        $this->feedName = $feedName;
        return $this;
    }

    /**
     * @return string
     */
    public function getFeedName() {
        return $this->feedName;
    }

    /**
     * Actually gets feed contents, either from apc or network. Contents is stored 1 hour if everything is ok and 1 minute an empty string if there is an error
     * @param string $url
     * @return string
     */
    public function getFeedContents($url) {
        $apcKey = 'sfmrss_' . md5($this->getFeedName());
        if (extension_loaded('apc')) {
            if (apc_exists($apcKey)) {
                $rssString = apc_fetch($apcKey);
            } else {
                $rssString = file_get_contents($url);
                if (!$rssString) {
                    apc_store($apcKey, '', 60);
                } else {
                    apc_store($apcKey, $rssString, 3600);
                }
            }
        } else {
            $rssString = file_get_contents($url);
        }

        return $rssString;
    }

    /**
     * Reads RSS and returns item array.
     * @return array
     */
    public function parseRss() {
        $rssString = $this->getRawFeed();
        if (empty($rssString)) {
            return array();
        } else {
            try {
                $rss = simplexml_load_string($rssString);
                return $rss->channel[0]->item;
            } catch (Exception $e) {
                return array();
            }
        }
    }

}