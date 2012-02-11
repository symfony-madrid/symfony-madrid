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
        return new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            __DIR__ . '/_files/events.yml'
        );
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function createEntityManager()
    {
        // Boot in test environment
        $kernel = new \AppKernel('test', true);
        $kernel->boot();

        // Retrieve the EntityManager
        $em = $kernel->getContainer()->get('doctrine')->getEntityManager();
        $em->getEventManager()->addEventListener('preTestSetUp', new SchemaSetupListener());

        return $em;
    }


    public function testGetPastEvents()
    {
        $expected = $this->createFlatXMLDataSet(__DIR__ . '/_files/past-events-test.xml')->getTable('events');

        $sql = $this->getEntityManager()->createQuery('SELECT e from SFBCNWebsiteBundle:Event e WHERE e.datetime < :datetime ORDER BY e.datetime DESC')
                                        ->setMaxResults(15)
                                        ->setParameter('datetime', new \DateTime())
                                        ->getSQL();

        /** @var \Doctrine\ORM\EntityManager $em  */
        $em = $this->getEntityManager();
        var_dump($em->getConnection()->fetchAll($sql));
        exit;

        $actual = $this->getConnection()->createQueryTable('events', $sql);

        $this->assertTablesEqual($expected, $actual);
    }
}