<?php

namespace SFM\WebsiteBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SFM\WebsiteBundle\Entity\Event;

class LoadEvents extends AbstractFixture implements OrderedFixtureInterface {

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        for ($i = 1; $i <= 12; $i++) {
            $event = new Event();
            $event->setTitle('Lorem Ipsum is simply dummy text of the printing and typesetting industry.');
            $event->setLocation('Ciball. Calle Corredera Baja de San Pablo, 41. 28004 Madrid');
            $offset = (int) rand(0, 365);
            if (round(rand(0, 1))) {
                $event->setDatetime(new \DateTime('now + ' . $offset . ' days'));
            } else {
                $event->setDatetime(new \DateTime('now - ' . $offset . ' days'));
            }
            $event->setBody('Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.');
            $event->setGmaps('http://maps.google.es/maps?f=q&source=embed&hl=es&geocode=&q=Calle+Corredera+Baja+de+San+Pablo,+41+28004+Madrid&aq=&sll=40.422334,-3.70404&sspn=0.010863,0.01929&vpsrc=0&ie=UTF8&hq=&hnear=Calle+Corredera+Baja+de+San+Pablo,+41,+28004+Madrid,+Comunidad+de+Madrid&ll=40.422318,-3.704023&spn=0.013983,0.020685&z=14&iwloc=A');
            $manager->persist($event);
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder() {
        return 1;
    }

}