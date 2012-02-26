<?php

namespace SFM\WebsiteBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\ORM\Tools\SchemaTool;

class DefaultControllerTest extends WebTestCase
{
    /**
     * Test case for the home page
     */
    public function testIndex()
    {
        $this->markTestSkipped('DOM Crawler has not support for HTML5 yet!');
        $client = static::createClient();

        /** @var \Symfony\Component\DomCrawler\Crawler $crawler */
        $crawler = $client->request('GET', '/');

        $this->assertTrue(200 == $client->getResponse()->getStatusCode(), 'Home page is not returning a 200 OK!!');
        $this->assertTrue(1 == $crawler->filter('span.next-event-date')->count(), 'Unable to find element with selector "span.next-event-date"');
        $this->assertTrue(1 == $crawler->filter('span.next-event-location')->count(), 'Unable to find element with selector "span.next-event-location"');
    }

    /**
     * Test case for the about us page
     */
    public function testAboutUsPage()
    {
        $this->markTestSkipped('DOM Crawler has not support for HTML5 yet!');
        $client = static::createClient();

        /** @var \Symfony\Component\DomCrawler\Crawler $crawler */
        $crawler = $client->request('GET', '/acerca-de');

        $this->assertTrue(200 == $client->getResponse()->getStatusCode(), 'About us page is not returning a 200 OK!!');
        $this->assertTrue($crawler->filter('li.founder')->count() > 0, 'There are no founders to display!!');
        $this->assertTrue($crawler->filter('li.member')->count() > 0, 'There are no members to display!!');
    }

    /**
     * Test the contact form submit page
     */
    public function testCanSendContactForms()
    {
        $this->markTestSkipped('DOM Crawler has not support for HTML5 yet!');
        $client = static::createClient();

        /** @var \Symfony\Component\DomCrawler\Crawler $crawler */
        $crawler = $client->request('GET', '/contacto');

        $this->assertTrue(200 == $client->getResponse()->getStatusCode(), 'Contact page is not returning a 200 OK!!');
        $form = $crawler->selectButton('Enviar')->form(array(
            'nombre' => 'Test',
            'email'  => 'test@test.com',
            'mensaje' => 'This is a test message!'
        ));

        $client->submit($form);

        // JSON response
        $this->assertTrue(200 == $client->getResponse()->getStatusCode(), 'Form submit is not returning a 200 OK!!');
        $this->assertEquals(json_encode(array('message' => 'Mail enviado correctamente. En breve contactaremos contigo')), $client->getResponse()->getContent(), 'Cannot send contact forms!!');
    }
}
