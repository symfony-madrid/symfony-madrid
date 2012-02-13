<?php

namespace SFBCN\WebsiteBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EventControllerTest extends WebTestCase
{
    public function testEventsIndex()
    {
        $client = static::createClient();

        /** @var \Symfony\Component\DomCrawler\Crawler $crawler */
        $crawler = $client->request('GET', '/eventos');

        $this->assertTrue(200 == $client->getResponse()->getStatusCode(), 'Events page is not returning a 200 OK!!');

        $this->assertTrue(1 == $crawler->filter('p.next-event-details')->count(), 'Not found the next event details!!');
        $this->assertTrue(1 == $crawler->filter('div.map')->count(), 'Not found the next event location map!!');
        $this->assertTrue(1 == $crawler->filter('p.future-event-details')->count(), 'Not found the future events details!!');
        $this->assertTrue(3 == $crawler->filter('p.past-event-details')->count(), 'Not found the past event details!!');
    }

    public function testEventDetails()
    {
        $client = static::createClient();

        /** @var \Symfony\Component\DomCrawler\Crawler $crawler */
        $crawler = $client->request('GET', '/eventos/show/12');

        $this->assertTrue(200 == $client->getResponse()->getStatusCode(), 'Event details page is not returning a 200 OK!!');
        $this->assertTrue(1 == $crawler->filter('p.event-details')->count(), 'Event details not found!!');
        $this->assertTrue(1 == $crawler->filter('div.event-map')->count(), 'Event location map not found!!');
    }
}