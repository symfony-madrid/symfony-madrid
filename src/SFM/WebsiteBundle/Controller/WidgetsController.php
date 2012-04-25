<?php

namespace SFM\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\HttpException;

class WidgetsController extends Controller {

    private function getFeedForUrl($url) {
        /** @var \SFM\WebsiteBundle\Service\RssReaderService $rssReaderService */
        $rssReaderService = $this->get('symfony_rss');
        $rssReaderService->setFeedName(md5($url));
        $rssReaderService->setRawFeed($rssReaderService->getFeedContents($url));
        return $rssReaderService->parseRss();
    }

    /**
     * Google group widget
     *
     * @return Response
     *
     * @Template("SFMWebsiteBundle:Widgets:google-group.html.twig")
     * @Route("/widgets/google-group", name="widgets_google_group")
     */
    public function googleGroupAction() {
        return array('feed' => $this->getFeedForUrl('https://groups.google.com/group/symfony_madrid/feed/rss_v2_0_topics.xml'));
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
        return array('feed' => $this->getFeedForUrl('http://api.twitter.com/1/statuses/user_timeline.rss?screen_name=symfony_madrid'));
    }

    /**
     * Flickr group widget
     *
     * @return Response
     *
     * @Template("SFMWebsiteBundle:Widgets:flickr.html.twig")
     * @Route("/widgets/flickr", name="widgets_flickr")
     */
    public function flickrAction() {
        return array('feed' => $this->getFeedForUrl('http://www.degraeve.com/flickr-rss/rss.php?tags=symfony-live&tagmode=all&num=3&sort=date-posted-desc'));
    }
    
     /**
     * Vimeo group widget
     *
     * @return Response
     *
     * @Template("SFMWebsiteBundle:Widgets:vimeo.html.twig")
     * @Route("/widgets/vimeo", name="widgets_vimeo")
     */
    public function vimeoAction() {
        die (var_dump($this->getFeedForUrl('http://vimeo.com/api/v2/decharlas/videos.xml')));
        return array('feed' => $this->getFeedForUrl('http://vimeo.com/api/v2/decharlas/videos.xml'));
    }

}
