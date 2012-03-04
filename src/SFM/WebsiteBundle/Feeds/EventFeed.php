<?php

namespace SFM\WebsiteBundle\Feeds;

use Nekland\FeedBundle\Item\ItemInterface;

abstract class EventFeed implements ItemInterface
{

    public function getFeedTitle()
    {
        return $this->getTitle() . ' - Symfony Madrid';
    }

    public function getFeedDescription()
    {
        return $this->getBody();
    }

    public function getFeedRoutes()
    {
        $routes = array(array('events_feed', array('id')), 'url' => 'http://symfony-madrid.es');
        return $routes;
    }

    public function getFeedId()
    {
        return $this->getId();
    }

    public function getFeedDate()
    {
        return $this->getDatetime();
    }
}
