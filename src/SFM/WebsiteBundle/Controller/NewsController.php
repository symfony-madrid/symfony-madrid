<?php

namespace SFM\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class NewsController extends Controller
{

    /**
     * Renders latest news
     *
     * @return array
     * @Route("/noticias", name="news_index")
     * @Template()
     */
    public function indexAction()
    {
        $this->client = $this->get('d2_client_rss');

        $response = $this->render('SFMWebsiteBundle:News:index.html.twig', array(
            'feeds'   =>  $this->client->fetch('symfony_madrid_guys'),
            'current' => 'news',
                ));

        $response->setCache(array('public'   => true, 's_maxage' => 60 * 60 * 12));

        return $response;
    }

}