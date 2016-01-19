<?php

namespace Wk\GoogleSpreadsheetBundle\Services;

use Google\Spreadsheet\DefaultServiceRequest;
use \Google_Client;
use \Google_Auth_OAuth2;

/**
 * Class OAuth2ServiceRequest
 * @package Wk\GoogleSpreadsheetBundle\Model
 */
class OAuth2ServiceRequest extends DefaultServiceRequest
{
    /**
     * @var Google_Client
     */
    private $client;

    /**
     * @param string $serviceAccountJsonFile
     * @param string $scope
     */
    public function __construct($serviceAccountJsonFile, $scope)
    {
        $this->client = new Google_Client();
        $credentials = $this->client->loadServiceAccountJson($serviceAccountJsonFile, array($scope));
        $this->client->setAssertionCredentials($credentials);

        parent::__construct('');
    }

    /**
     * {@inheritdoc}
     */
    protected function initRequest($url, $requestHeaders = array())
    {
        /** @var Google_Auth_OAuth2 $auth */
        $auth = $this->client->getAuth();

        if ($auth->isAccessTokenExpired()) {
            $auth->refreshTokenWithAssertion();
        }

        $accessTokenArray = json_decode($auth->getAccessToken(), true);

        $this->accessToken = isset($accessTokenArray['access_token']) ? $accessTokenArray['access_token'] : null;

        return parent::initRequest($url, $requestHeaders);
    }
}