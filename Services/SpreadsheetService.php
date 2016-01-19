<?php

namespace Wk\GoogleSpreadsheetBundle\Services;

use Google\Spreadsheet\ServiceRequestFactory;
use Google\Spreadsheet\SpreadsheetService as BaseSpreadsheetService;

/**
 * Class SpreadsheetService
 * @package Wk\GoogleSpreadsheetBundle\Services
 */
class SpreadsheetService extends BaseSpreadsheetService
{
    /**
     * @param OAuth2ServiceRequest $oAuth2ServiceRequest
     */
    public function __construct(OAuth2ServiceRequest $oAuth2ServiceRequest)
    {
        ServiceRequestFactory::setInstance($oAuth2ServiceRequest);
    }
}