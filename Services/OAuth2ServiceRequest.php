<?php

namespace Wk\GoogleSpreadsheetBundle\Services;

use Google\Spreadsheet\DefaultServiceRequest;
use \Google_Client;
use \Google_Auth_OAuth2;
use \Google_Auth_AssertionCredentials;

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
     * set google client
     */
    public function __construct()
    {
        $this->client = new Google_Client();

        parent::__construct('');
    }

    /**
     * @param string $scope
     * @param string $clientEmail
     * @param string $privateKey
     *
     * @return $this
     */
    public function setCredentials($scope, $clientEmail, $privateKey)
    {
        $assertionCredentials = new Google_Auth_AssertionCredentials($clientEmail, array($scope), $privateKey);

        $this->client->setAssertionCredentials($assertionCredentials);

        return $this;
    }

    /**
     * @return string|null
     */
    public function refreshExpiredToken()
    {
        /** @var Google_Auth_OAuth2 $auth */
        $auth = $this->client->getAuth();

        if ($auth->isAccessTokenExpired()) {
            $auth->refreshTokenWithAssertion();
        }

        $accessTokenArray = json_decode($auth->getAccessToken(), true);

        return ($accessTokenArray && isset($accessTokenArray['access_token'])) ? $accessTokenArray['access_token'] : null;
    }

    /**
     * {@inheritdoc}
     */
    protected function initRequest($url, $requestHeaders = [])
    {
        $this->accessToken = $this->refreshExpiredToken();

        return parent::initRequest($url, $requestHeaders);
    }
}