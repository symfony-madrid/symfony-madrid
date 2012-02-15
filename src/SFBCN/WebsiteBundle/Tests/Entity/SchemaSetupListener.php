<?php
/**
 * A Doctrine2 event listener definition
 *
 * @category ComponentTests
 * @package SFBCN\WebsiteBundle\Tests
 * @subpackage Entity
 */

namespace SFBCN\WebsiteBundle\Tests\Entity;

use DoctrineExtensions\PHPUnit\Event\EntityManagerEventArgs,
    Doctrine\ORM\Tools\SchemaTool;

/**
 * A Doctrine2 event listener responsible to create an in-memory
 * database to be able to execute component tests
 *
 * @category ComponentTests
 * @package SFBCN\WebsiteBundle\Tests
 * @subpackage Entity
 */
class SchemaSetupListener
{
    /**
     * Creates a new database
     * @param \DoctrineExtensions\PHPUnit\Event\EntityManagerEventArgs $eventArgs
     */
    public function preTestSetUp(EntityManagerEventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager();
        $cmf = $em->getMetadataFactory();
        $classes = $cmf->getAllMetadata();

        $schemaTool = new SchemaTool($em);

        try {
            $schemaTool->dropSchema($classes);
        } catch (\Exception $e) {
            // Do nothing
        }

        $schemaTool->createSchema($classes);
    }
}
