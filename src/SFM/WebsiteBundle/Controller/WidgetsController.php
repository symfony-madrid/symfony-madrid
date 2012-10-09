<?php

namespace SFM\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\HttpException;

class WidgetsController extends Controller
{

    /**
     * Google group widget
     *
     * @return Response
     *
     * @Template("SFMWebsiteBundle:Widgets:google-group.html.twig")
     * @Route("/widgets/google-group", name="widgets_google_group")
     */
    public function googleGroupAction()
    {
        $rssClient = $this->get('rss_client');

        return array(
            'feeds' => $rssClient->fetch('google_groups', 5),
        );
    }

    /**
     * Twitter group widget
     *
     * @return Response
     *
     * @Template("SFMWebsiteBundle:Widgets:twitter.html.twig")
     * @Route("/widgets/twitter", name="widgets_twitter")
     */
    public function twitterAction()
    {
        $twitterClient = $this->container->get('twitter_client');

        return array(
            'feeds' => $twitterClient->fetch(6)
        );
    }

}
