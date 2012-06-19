<?php

namespace Desarrolla2\Bundle\RSSClientBundle\Test\Service;

use Desarrolla2\Bundle\RSSClientBundle\Service\RSSClient;

class RSSClientTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Desarrolla2\Bundle\RSSClientBundle\Service\RSSClient;
     */
    protected $client = null;

    public function setUp()
    {
        $this->client = new RSSClient();
    }

    /**
     * @test
     */
    public function testAddFeed()
    {
        $this->client->addFeed('feed1');
        $this->assertEquals(count($this->client->getFeeds()), 1);
    }

    /**
     * @test
     */
    public function testAddFeeds()
    {
        $this->client->addFeeds(array('feed1', 'feed2'));
        $this->client->addFeeds(array('feed3', 'feed4'));
        $this->assertEquals(count($this->client->getFeeds()), 4);
    }

    /**
     * @test
     */
    public function testClearFeeds()
    {
        $this->client->addFeed('feed1');
        $this->client->clearFeeds();
        $this->assertEquals(count($this->client->getFeeds()), 0);
    }
    
    /**
     * @test
     */
    public function testSetFeeds()
    {
        $this->client->addFeed('feed1');       
        $this->client->setFeeds(array('feed1'));
        $this->assertEquals(count($this->client->getFeeds()), 1);
    }

    /**
     * @test
     */
    public function testFetch()
    {
        $this->client->addFeed('http://desarrolla2.com/feed/');
        $this->client->fetch();
        $this->assertTrue(true);
    }

}