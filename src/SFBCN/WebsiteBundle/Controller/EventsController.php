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
     * @Route("", name="events_public_index")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $nextEvent = $em->getRepository('SFBCNWebsiteBundle:Event')->getNextEvent();
        $pastEvents = $em->getRepository('SFBCNWebsiteBundle:Event')->getPastEvents();
        $futureEvents = $em->getRepository('SFBCNWebsiteBundle:Event')->getFutureEvents();

        return array(
            'nextEvent' => $nextEvent,
            'pastEvents' => $pastEvents,
            'futureEvents' => $futureEvents,
            'current' => 'events',
        );
    }

    /**
     * Shows event requested
     *
     * @param integer $id
     * @return array
     * @Route("/show/{id}", name="events_public_show", requirements={"id"="\d+"})
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $event = $em->getRepository('SFBCNWebsiteBundle:Event')->find($id);

        return array(
            'event' => $event,
            'current' => 'events',
        );
    }
}
