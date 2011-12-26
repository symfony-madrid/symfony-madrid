<?php

namespace SFBCN\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/eventos")
 */
class EventsController extends Controller
{
    /**
     * Renders latest events
     *
     * @return array
     * @Route("", name="events_index")
     * @Template()
     */
    public function indexAction()
    {
        return array(
            'current' => 'events',
        );
    }
}
