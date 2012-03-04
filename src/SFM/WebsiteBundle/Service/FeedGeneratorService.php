<?php

namespace SFM\WebsiteBundle\Service;

class FeedGeneratorService
{

    private $feedFactory;
    private $em;

    public function __construct($feedFactory, \Doctrine\ORM\EntityManager $em)
    {
        $this->feedFactory = $feedFactory;
        $this->em = $em;
    }

    public function generateEventsFeed($type = 'rss', $max = 0)
    {
        $events = $this->em->getRepository('SFMWebsiteBundle:Event')->findAll();
        $feed = $this->feedFactory->load('event', 'rss_file');
        foreach ($events as $i => $event) {
            if (!$feed->offsetExists($i)) {
                $feed->add($event);
            }
        }
        $this->feedFactory->render('event', 'rss');
    }
}
