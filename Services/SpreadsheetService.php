<?php

namespace Wk\GoogleSpreadsheetBundle\Services;

use Google\Spreadsheet\ServiceRequestFactory;
use Google\Spreadsheet\SpreadsheetService as BaseSpreadsheetService;
use Wk\GoogleSpreadsheetBundle\Model\OAuth2ServiceRequest;

/**
 * Class SpreadsheetService
 * @package Wk\GoogleSpreadsheetBundle\Services
 */
class SpreadsheetService extends BaseSpreadsheetService
{
    /**
     * @param string $serviceAccountJsonFile
     * @param string $scope
     */
    public function __construct($serviceAccountJsonFile, $scope)
    {
        $oAuth2ServiceRequest = new OAuth2ServiceRequest($serviceAccountJsonFile, $scope);
        ServiceRequestFactory::setInstance($oAuth2ServiceRequest);
    }
}