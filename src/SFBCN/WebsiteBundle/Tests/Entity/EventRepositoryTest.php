<?php
/**
 * A component test definition
 *
 * @category ComponentTests
 * @package SFBCN\WebsiteBundle\Tests
 * @subpackage Entity
 */

namespace SFBCN\WebsiteBundle\Tests\Entity;

require_once dirname(__DIR__) . '/../../../../app/AppKernel.php';

use DoctrineExtensions\PHPUnit\OrmTestCase,
    Doctrine\ORM\Tools\SchemaTool,
    Doctrine\ORM\EntityManager,
    Doctrine\Common\EventManager,
    SFBCN\WebsiteBundle\Entity\EventRepository;

/**
 * Component test for the EventRespository
 *
 * @category ComponentTests
 * @package SFBCN\WebsiteBundle\Tests
 * @subpackage Entity
 */
class EventRepositoryTest extends OrmTestCase
{
    /**
     * Returns the test dataset.
     *
     * @return \PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        return $this->createFlatXMLDataSet(__DIR__ . '/_files/events.xml');
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function createEntityManager()
    {
        // Boot in test environment
        try {
            $kernel = new \AppKernel('travis', true);
            $kernel->boot();
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }

        // Retrieve the EntityManager
        $em = $kernel->getContainer()->get('doctrine')->getEntityManager();
        $em->getEventManager()->addEventListener('preTestSetUp', new SchemaSetupListener());

        return $em;
    }

    public function testGetPastEvents()
    {
        $expected = $this->createFlatXMLDataSet(__DIR__ . '/_files/past-events.xml')->getTable('events');
        $now = new \DateTime();
        $actual = $this->getConnection()->createQueryTable('events', 'SELECT * FROM events WHERE datetime < \'' . $now->format('Y-m-d H:i:s') . '\' ORDER BY datetime DESC LIMIT 15');

        $this->assertTablesEqual($expected, $actual);
    }

    public function testGetNextEvent()
    {
        $expected = $this->createFlatXMLDataSet(__DIR__ . '/_files/next-event.xml')->getTable('events');
        $now = new \DateTime();
        $actual = $this->getConnection()->createQueryTable('events', 'SELECT * FROM events e WHERE e.datetime > \'' . $now->format('Y-m-d H:i:s') . '\' ORDER BY e.datetime ASC LIMIT 1');

        $this->assertTablesEqual($expected, $actual);
    }

    public function testGetFutureEvents()
    {
        $expected = $this->createFlatXMLDataSet(__DIR__ . '/_files/future-events.xml')->getTable('events');
        $now = new \DateTime();
        $actual = $this->getConnection()->createQueryTable('events', 'SELECT * FROM events e WHERE e.datetime > \'' . $now->format('Y-m-d H:i:s') . '\' ORDER BY e.datetime ASC LIMIT 15 OFFSET 1');

        $this->assertTablesEqual($expected, $actual);
    }
}