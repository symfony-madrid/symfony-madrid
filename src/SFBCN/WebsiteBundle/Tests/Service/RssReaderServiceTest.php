<?php
/**
 * Test suite file definition
 *
 * @category UnitTests
 * @package SFBCN\WebsiteBundle\Tests
 * @subpackage Service
 */
namespace SFBCN\WebsiteBundle\Tests\Service;

use SFBCN\WebsiteBundle\Service\RssReaderService;

/**
 * Tests the RSS reader service
 *
 * @category UnitTests
 * @package SFBCN\WebsiteBundle\Tests
 * @subpackage Service
 */
class RssReaderServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \SFBCN\WebsiteBundle\Service\RssReaderService
     */
    private $rssReaderService;

    protected function setUp()
    {
        // Prepare the fixture
        $this->rssReaderService = new RssReaderService();
    }

    protected function tearDown()
    {
        // Clear the fixture
        apc_clear_cache();
        $this->rssReaderService = null;
    }

    public function testParseRSS()
    {
        $cacheKey = 'sfbcnrss_' . md5('test');
        apc_delete($cacheKey);
        $this->rssReaderService->setFeedName('test')
                               ->setRawFeed(<<<EOX
<?xml version="1.0" encoding="utf-8"?>
<channels>
    <channel>
        <item>Item1</item>
        <item>Item2</item>
    </channel>
</channels>
EOX
        );

        $result = $this->rssReaderService->parseRss();

        $this->assertInstanceOf('SimpleXMlElement', $result);
        $this->assertTrue(apc_exists($cacheKey));
    }
}
