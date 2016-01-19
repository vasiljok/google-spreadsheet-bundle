<?php

namespace Wk\GoogleSpreadsheetBundle\Model;

use Google\Spreadsheet\DefaultServiceRequest;

/**
 * Class OAuth2ServiceRequest
 * @package Wk\GoogleSpreadsheetBundle\Model
 */
class OAuth2ServiceRequest extends DefaultServiceRequest {
    /**
     * @var OAuth2Client
     */
    private $oAuth2Client;

    /**
     * @param string $serviceAccountJsonFile
     * @param string $scope
     */
    public function __construct($serviceAccountJsonFile, $scope) {
        $this->oAuth2Client = new OAuth2Client($serviceAccountJsonFile, array($scope));

        parent::__construct('');
    }

    /**
     * {@inheritdoc}
     */
    protected function initRequest($url, $requestHeaders = array()) {
        $this->accessToken = $this->oAuth2Client->refreshToken();

        return parent::initRequest($url, $requestHeaders);
    }
}