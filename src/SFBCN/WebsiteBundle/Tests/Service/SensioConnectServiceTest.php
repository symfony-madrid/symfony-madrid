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

/**
 * Test the integration between SensioConnect and Symfony Barcelona
 *
 * @category UnitTests
 * @package SFBCN\WebsiteBundle\Tests
 * @subpackage Service
 */
class SensioConnectServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \SFBCN\WebsiteBundle\Service\SensioConnectService
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

    public function testGetGroupInfo()
    {
        $result = $this->sensioConnectService->setGroupName('symfony-barcelona')
                                             ->getGroupInfo();

        $this->assertInternalType('array', $result);
        $this->assertArrayHasKey('club_url', $result);
        $this->assertEquals('https://connect.sensiolabs.com/club/symfony-barcelona', $result['club_url']);
    }
}
