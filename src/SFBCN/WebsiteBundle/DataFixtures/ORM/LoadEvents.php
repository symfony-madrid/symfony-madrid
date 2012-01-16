<?php

namespace SFBCN\WebsiteBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use SFBCN\WebsiteBundle\Entity\Event;

class LoadEvents extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load($manager)
    {
        $ev = new Event();
        $ev->setTitle('Reunión inicial Symfony Barcelona');
        $ev->setLocation('La Flauta II, Balmes 166, 08008, Barcelona');
        $ev->setDatetime(new \DateTime('2011-10-20 19:45:00'));
        $ev->setBody('Esta reunión sirvió para conocernos y sentar las bases de lo que debía ser el grupo Symfony-Barcelona');
        $ev->setGmaps('http://maps.google.es/maps?f=q&source=s_q&hl=es&geocode=&q=barcelona,+la+flauta,+balmes&vps=5&jsv=151e&sll=41.402501,2.161903&sspn=0.016771,0.038452&ie=UTF8&ei=SR7NSZDTAoXsoAOtwMk_&sig2=jlbDNae-UxT_9_IaQvWvhQ&cd=1&dtab=5&cid=41394756,2155491,11093431450005803032&li=lmd&z=14&t=m');
        $manager->persist($ev);

        $ev = new Event();
        $ev->setTitle('Reunión status y nuevas incorporaciones');
        $ev->setLocation('La Flauta II, Balmes 166, 08008, Barcelona');
        $ev->setDatetime(new \DateTime('2012-01-11 19:45:00'));
        $ev->setBody('En esta reunión se unieron nuevos miembros al grupo y parece que por fin la cosa empieza a funcionar');
        $ev->setGmaps('http://maps.google.es/maps?f=q&source=s_q&hl=es&geocode=&q=barcelona,+la+flauta,+balmes&vps=5&jsv=151e&sll=41.402501,2.161903&sspn=0.016771,0.038452&ie=UTF8&ei=SR7NSZDTAoXsoAOtwMk_&sig2=jlbDNae-UxT_9_IaQvWvhQ&cd=1&dtab=5&cid=41394756,2155491,11093431450005803032&li=lmd&z=14&t=m');
        $manager->persist($ev);

        $ev = new Event();
        $ev->setTitle('Presentación en sociedad de Symfony-Barcelona');
        $ev->setLocation('Por determinar');
        $ev->setDatetime(new \DateTime('2012-02-01 19:45:00'));
        $ev->setBody('Esta reunión servirá para ver cuánto interés hay por parte de la comunidad. La idea es que sea Beers & Networking pero nunca se sabe... :)');
        $ev->setGmaps('http://maps.google.es/maps?f=q&source=s_q&hl=es&geocode=&q=barcelona,+la+flauta,+balmes&vps=5&jsv=151e&sll=41.402501,2.161903&sspn=0.016771,0.038452&ie=UTF8&ei=SR7NSZDTAoXsoAOtwMk_&sig2=jlbDNae-UxT_9_IaQvWvhQ&cd=1&dtab=5&cid=41394756,2155491,11093431450005803032&li=lmd&z=14&t=m');
        $manager->persist($ev);

        $ev = new Event();
        $ev->setTitle('Primer taller Symfony-Barcelona');
        $ev->setLocation('Por determinar');
        $ev->setDatetime(new \DateTime('2012-03-01 19:45:00'));
        $ev->setBody('Esta reunión servirá para hacer algún taller o presentaciones sobre Symfony. Pendiente montar programa');
        $ev->setGmaps('http://maps.google.es/maps?f=q&source=s_q&hl=es&geocode=&q=barcelona,+la+flauta,+balmes&vps=5&jsv=151e&sll=41.402501,2.161903&sspn=0.016771,0.038452&ie=UTF8&ei=SR7NSZDTAoXsoAOtwMk_&sig2=jlbDNae-UxT_9_IaQvWvhQ&cd=1&dtab=5&cid=41394756,2155491,11093431450005803032&li=lmd&z=14&t=m');
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