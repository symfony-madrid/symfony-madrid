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
    public function googleGroupAction()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://groups.google.com/group/symfony_madrid/feed/rss_v2_0_topics.xml');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $feed = new \SimpleXMLElement(curl_exec($ch));

        curl_close($ch);

        return array('feed' => $feed);

    }
}
