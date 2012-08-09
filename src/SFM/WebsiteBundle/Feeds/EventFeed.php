<?php

namespace SFM\WebsiteBundle\Feeds;

abstract class EventFeed
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
