<?php

namespace SFM\WebsiteBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SFM\WebsiteBundle\Entity\Event;

class LoadEvents extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $ev = new Event();
        $ev->setTitle('Reunión Febrero 2012');
        $ev->setLocation('Ciball. Calle Corredera Baja de San Pablo, 41. 28004 Madrid');
        $ev->setDatetime(new \DateTime('2012-03-01 18:00:00'));
        $ev->setBody('En esta reunión, Miquel Camps Orteza (@miquelcamps) nos contará cómo ha desarrollado el directorio de profesionales Betabeers utilizando el framework Symfony2');
        $ev->setGmaps('http://maps.google.es/maps?f=q&source=embed&hl=es&geocode=&q=Calle+Corredera+Baja+de+San+Pablo,+41+28004+Madrid&aq=&sll=40.422334,-3.70404&sspn=0.010863,0.01929&vpsrc=0&ie=UTF8&hq=&hnear=Calle+Corredera+Baja+de+San+Pablo,+41,+28004+Madrid,+Comunidad+de+Madrid&ll=40.422318,-3.704023&spn=0.013983,0.020685&z=14&iwloc=A');
        $manager->persist($ev);

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}