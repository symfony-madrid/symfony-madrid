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
        $rssNewsArray = array();
        $RSSrenderService = $this->get('symfony_rss');
        $feedsRss = $RSSrenderService->getFeedsRss();

        foreach($feedsRss As $key=>$value){
            $RSSrenderService->setUrlResource($value);
            $rssNewsArray[] = $RSSrenderService->parseRss();
//            ladybug_dump_die($RSSrenderService->parseRss());
        }

        return array(
            'rssnewsArray' => $rssNewsArray,
            'current' => 'news',
        );
    }
}