<?php
/**
 * Test suite file definition
 *
 * @category UnitTests
 * @package SFM\WebsiteBundle\Tests
 * @subpackage Service
 */
namespace SFM\WebsiteBundle\Tests\Service;

use SFM\WebsiteBundle\Service\RssReaderService;

/**
 * Tests the RSS reader service
 *
 * @category UnitTests
 * @package SFM\WebsiteBundle\Tests
 * @subpackage Service
 */
class RssReaderServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \SFM\WebsiteBundle\Service\RssReaderService
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
        if ((boolean) ini_get('apc.enable_cli')) {
            apc_clear_cache();
        }
        
        $this->rssReaderService = null;
    }

    public function testParseRSS()
    {
        $isApcEnabled = (boolean) ini_get('apc.enable_cli');
        $cacheKey = 'sfmrss_' . md5('test');

        if ($isApcEnabled) {
            apc_delete($cacheKey);
        }

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

        $this->assertInstanceOf('SimpleXMlElement', $result, 'The result isn\'t a SimpleXMLElement instance!');

        if ($isApcEnabled) {
            $this->assertTrue(apc_exists($cacheKey), 'RSS feed not cached!!');
        }
    }
}
