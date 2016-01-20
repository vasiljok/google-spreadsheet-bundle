<?php

namespace Wk\GoogleSpreadsheetBundle\Tests\Services;

use Google\Spreadsheet\ServiceRequestFactory;
use Symfony\Bundle\FrameworkBundle\Client;
use Wk\GoogleSpreadsheetBundle\Services\SpreadsheetService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use \PHPUnit_Framework_MockObject_MockObject;

/**
 * Class SpreadsheetServiceTest
 * @package Wk\GoogleSpreadsheetBundle\Tests\Services
 */
class SpreadsheetServiceTest extends WebTestCase
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $mockServiceRequest;

    /**
     * @var SpreadsheetService
     */
    private $speadsheetService;

    /**
     * set up client
     */
    public function setUp()
    {
        $this->client = static::createClient();

        $this->mockServiceRequest = $this->getMockBuilder('Wk\GoogleSpreadsheetBundle\Services\OAuth2ServiceRequest')
            ->disableOriginalConstructor()
            ->getMock();

        $this->speadsheetService = new SpreadsheetService($this->mockServiceRequest);
    }

    /**
     * test the instantiation of the service request object
     */
    public function testSettingOfServiceRequestInstance()
    {
        $this->assertEquals($this->mockServiceRequest, ServiceRequestFactory::getInstance());
    }

    /**
     * @return array
     */
    public function provideServiceDescription()
    {
        return [
            ['nonexistentservice', false],
            ['wk_google_spreadsheet', true]
        ];
    }

    /**
     * @param string $serviceName
     * @param bool   $serviceExists
     *
     * @dataProvider provideServiceDescription
     */
    public function testServiceDescription($serviceName, $serviceExists)
    {
        if (!$serviceExists) {
            $this->setExpectedException('Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException', 'You have requested a non-existent service "' . $serviceName . '".');
        }

        $this->client->getContainer()->get($serviceName);
    }

    /**
     * @return array
     */
    public function provideMethodIsAccessible()
    {
        return [
            ['getSpreadsheets', true],
            ['getSpreadsheetById', true],
            ['getListFeed', true],
            ['getCellFeed', true],
            ['nonexistingMethod', false],
        ];
    }

    /**
     * @param string $method
     * @param bool   $methodExists
     *
     * @dataProvider provideMethodIsAccessible
     */
    public function testMethodIsAccessible($method, $methodExists)
    {
        $this->assertEquals($methodExists, method_exists($this->speadsheetService, $method));
    }
}