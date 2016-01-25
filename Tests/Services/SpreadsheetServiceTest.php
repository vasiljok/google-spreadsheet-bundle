<?php

namespace Wk\GoogleSpreadsheetBundle\Tests\Services;

use Google\Spreadsheet\ServiceRequestFactory;
use Google\Spreadsheet\Spreadsheet;
use Wk\GoogleSpreadsheetBundle\Services\OAuth2ServiceRequest;
use Wk\GoogleSpreadsheetBundle\Services\SpreadsheetService;
use \PHPUnit_Framework_MockObject_MockObject;
use \PHPUnit_Framework_TestCase;

/**
 * Class SpreadsheetServiceTest
 * @package Wk\GoogleSpreadsheetBundle\Tests\Services
 */
class SpreadsheetServiceTest extends PHPUnit_Framework_TestCase
{
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