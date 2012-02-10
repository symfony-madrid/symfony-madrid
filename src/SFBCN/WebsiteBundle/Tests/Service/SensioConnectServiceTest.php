<?php
/**
 * Test suite file definition
 *
 * @category UnitTests
 * @package SFBCN\WebsiteBundle\Tests
 * @subpackage Service
 */
namespace SFBCN\WebsiteBundle\Tests\Service;

use SFBCN\WebsiteBundle\Service\SensioConnectService;

class SensioConnectServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \SFBCN\WebsiteBundle\Service\SensionConnectService
     */
    private $sensioConnectService;

    protected function setUp()
    {
        // Prepare the fixture
        $this->sensioConnectService = new SensioConnectService();
    }

    protected function tearDown()
    {
        // Clear the fixture
        $this->sensioConnectService = null;
    }


}
