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
    private $eventRepository;

    /**
     * Renders latest events
     *
     * @return array
     * @Route("", name="events_public_index")
     * @Template()
     */
    public function indexAction()
    {
        $nextEvent = $this->getEventRepository()->getNextEvent();
        $pastEvents = $this->getEventRepository()->getPastEvents(5);
        $futureEvents = $this->getEventRepository()->getFutureEvents(5);

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
        $event = $this->getEventRepository()->find($id);

        return array(
            'event' => $event,
            'current' => 'events',
        );
    }

    /**
     * @return \SFBCN\WebsiteBundle\Entity\EventRepository
     */
    private function getEventRepository()
    {
        if (null === $this->eventRepository) {
            $this->eventRepository = $this->getDoctrine()->getEntityManager()->getRepository('SFBCNWebsiteBundle:Event');
        }

        return $this->eventRepository;
    }
}
