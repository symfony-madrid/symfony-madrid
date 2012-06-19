<?php

namespace Desarrolla2\Bundle\RSSClientBundle\Service;

class RSSClient
{

    protected $feeds = array();
    protected $nodes = array();

    public function __construct()
    {
        
    }

    /**
     * @return array feeds
     */
    public function getFeeds()
    {
        return $this->feeds;
    }

    /**
     * 
     */
    public function clearFeeds()
    {
        $this->feeds = array();
    }

    /**
     *
     * @param array $feeds 
     */
    public function setFeeds($feeds)
    {
        $this->clearFeeds();
        $this->addFeeds($feeds);
    }

    /**
     *
     * @param string $feed 
     */
    public function addFeed($feed)
    {
        array_push($this->feeds, (string) $feed);
    }

    /**
     *
     * @param array $feeds 
     */
    public function addFeeds($feeds)
    {
        $feeds = (array) $feeds;
        foreach ($feeds as $feed)
        {
            $this->addFeed($feed);
        }
    }

    /**
     * 
     */
    public function fetch()
    {
        foreach ($this->feeds as $feed)
        {
            $feed = @file_get_contents($feed);
            if ($feed)
            {
                $DOMDocument = new \DOMDocument();
                $DOMDocument->strictErrorChecking = false;
                if ($DOMDocument->loadXML($feed))
                {
                    foreach ($DOMDocument->childNodes as $childNode)
                    {
                        $this->addNode($childNode);
                    }
                }
            }
        }
    }

    /**
     * 
     */
    public function dump()
    {
        var_dump($feeds);
    }

}