<?php
/**
 * Test suite file definition
 *
 * @category UnitTests
 * @package SFM\WebsiteBundle\Tests
 * @subpackage Service
 */
namespace SFM\WebsiteBundle\Tests\Service;

use SFM\WebsiteBundle\Service\SensioConnectService;

/**
 * Test the integration between SensioConnect and Symfony Barcelona
 *
 * @category UnitTests
 * @package SFM\WebsiteBundle\Tests
 * @subpackage Service
 */
class SensioConnectServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \SFM\WebsiteBundle\Service\SensioConnectService
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

        if ((boolean) ini_get('apc.enable_cli')) {
            $this->assertTrue(apc_exists('sfm_sensioconnect'));
        }
    }
}
