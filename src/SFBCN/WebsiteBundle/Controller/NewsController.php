<?php

namespace SFBCN\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/noticias")
 */
class NewsController extends Controller
{
    /**
     * Renders latest news
     *
     * @return array
     * @Route("", name="news_index")
     * @Template()
     */
    public function indexAction()
    {
        $feeds = array();
        $rssReaderService = $this->get('symfony_rss');
        $feedsRss = $rssReaderService->getFeedsRss();

        foreach ($feedsRss as $feed) {
            $rssReaderService->setUrlResource($feed['url']);
            $feeds[] = array('name' => $feed['name'], 'posts' => $rssReaderService->parseRss());
        }

        return array(
            'feeds' => $feeds,
            'current' => 'news',
        );
    }
}