<?php

namespace Wk\GoogleSpreadsheetBundle\Tests\Services;

use Google\Spreadsheet\ServiceRequestFactory;
use Symfony\Bundle\FrameworkBundle\Client;
use Wk\GoogleSpreadsheetBundle\Services\SpreadsheetService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

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
     * set up client
     */
    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * test the instantiation of the service request object
     */
    public function testSettingOfServiceRequestInstance()
    {
        $testServiceRequest = $this->getMockBuilder('Wk\GoogleSpreadsheetBundle\Services\OAuth2ServiceRequest')
            ->disableOriginalConstructor()
            ->getMock();

        new SpreadsheetService($testServiceRequest);

        $this->assertEquals($testServiceRequest, ServiceRequestFactory::getInstance());
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
}