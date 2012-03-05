<?php

namespace SFM\WebsiteBundle\Service;

/**
 * FeedGeneratorService to allow generation of multiple feeds
 *
 * @package WebsiteBundle
 * @subpackage Service
 * @author Eduardo Gulias Davis <me@egulias.com>
 */
class FeedGeneratorService
{

    private $feedFactory;
    private $em;

    public function __construct($feedFactory, \Doctrine\ORM\EntityManager $em)
    {
        $this->feedFactory = $feedFactory;
        $this->em = $em;
    }

    /**
     * generateEventsFeed
     *
     * @param string $type
     * @access public
     * @return void
     */
    public function generateEventsFeed($type = 'rss')
    {
        $newFeeds = FALSE;
        $events = $this->em->getRepository('SFMWebsiteBundle:Event')->findAll();
        $feed = $this->feedFactory->load('event', $type.'_file');
        foreach ($events as $i => $event) {
            try {
                $feed->replace($event->getId(),$event);
            } catch (\InvalidArgumentException $e) {
                $feed->add($event);
            }
        }
        $this->feedFactory->render('event', $type);
    }

    /**
     * removeEventFromFeed
     *
     * @param string $type
     * @param \SFM\WebsiteBundle\Entity\Event $event
     * @access public
     * @return Boolean
     * @throw \Exception
     */
    public function removeEventFromFeed(\SFM\WebsiteBundle\Entity\Event $event, $type = 'rss')
    {
        try {
            $feed = $this->feedFactory->load('event', $type.'_file');
            $feed->remove((string)$event->getFeedId());
            $this->feedFactory->render('event', $type);
        } catch (\Exception $e) {
            throw $e;
        }
        return TRUE;
    }
}
