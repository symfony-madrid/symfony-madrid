<?php

namespace SFM\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\HttpException;

class WidgetsController extends Controller {

    /**
     * Google group widget
     *
     * @return Response
     *
     * @Template("SFMWebsiteBundle:Widgets:google-group.html.twig")
     * @Route("/widgets/google-group", name="widgets_google_group")
     */
    public function googleGroupAction() {

        $feeds = array();

        /** @var \SFM\WebsiteBundle\Service\RssReaderService $rssReaderService */
        $rssReaderService = $this->get('symfony_rss');
        $rssReaderService->setFeedName('google_group')
                ->setRawFeed($rssReaderService->getFeedContents('https://groups.google.com/group/symfony_madrid/feed/rss_v2_0_topics.xml'));



        return array('feed' => $rssReaderService->parseRss());
    }
    
        /**
     * Twitter group widget
     *
     * @return Response
     *
     * @Template("SFMWebsiteBundle:Widgets:twitter.html.twig")
     * @Route("/widgets/twitter", name="widgets_twitter")
     */
    public function twitterAction() {

        $feeds = array();

        /** @var \SFM\WebsiteBundle\Service\RssReaderService $rssReaderService */
        $rssReaderService = $this->get('symfony_rss');
        $rssReaderService->setFeedName('google_group')
                ->setRawFeed($rssReaderService->getFeedContents('http://api.twitter.com/1/statuses/user_timeline.rss?screen_name=symfony_madrid'));

        return array('feed' => $rssReaderService->parseRss());
    }

}
