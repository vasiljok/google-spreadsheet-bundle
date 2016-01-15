<?php

namespace Wk\GoogleSpreadsheetBundle\Services;

use Google\Spreadsheet\DefaultServiceRequest;
use Google\Spreadsheet\ServiceRequestFactory;
use Google\Spreadsheet\SpreadsheetService as BaseSpreadsheetService;

/**
 * Class SpreadsheetService
 * @package Wk\GoogleSpreadsheetBundle\Services
 */
class SpreadsheetService extends BaseSpreadsheetService
{
    /**
     * @param string $accessToken
     */
    public function __construct($accessToken)
    {
        ServiceRequestFactory::setInstance(new DefaultServiceRequest($accessToken));
    }
}