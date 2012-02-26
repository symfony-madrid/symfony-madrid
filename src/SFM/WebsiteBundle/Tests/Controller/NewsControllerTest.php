<?php

namespace SFM\WebsiteBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class NewsControllerTest extends WebTestCase
{
    public function testEventsIndex()
    {
        $this->markTestSkipped('DOM Crawler has not support for HTML5 yet!');
        $client = static::createClient();

        /** @var \Symfony\Component\DomCrawler\Crawler $crawler */
        $crawler = $client->request('GET', '/noticias');

        $this->assertTrue(200 == $client->getResponse()->getStatusCode(), 'News page is not returning a 200 OK!!');

        $this->assertTrue($crawler->filter('p.entry-content')->count() > 0, 'No feed entry found!!');
    }
}