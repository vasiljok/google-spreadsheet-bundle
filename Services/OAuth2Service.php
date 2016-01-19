<?php

namespace Wk\GoogleSpreadsheetBundle\Services;

use \Google_Client;
use \Google_Auth_OAuth2;

/**
 * Class OAuth2Service
 * @package Wk\GoogleSpreadsheetBundle\Services
 */
class OAuth2Service
{
    /**
     * @var Google_Auth_OAuth2
     */
    private $auth;

    /**
     * @param string $serviceAccountJsonFile
     * @param array  $scopes
     */
    public function __construct($serviceAccountJsonFile, array $scopes)
    {
        $client = new Google_Client();
        $credentials = $client->loadServiceAccountJson($serviceAccountJsonFile, $scopes);
        $client->setAssertionCredentials($credentials);

        $this->auth = $client->getAuth();
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->auth->getAccessToken();
    }

    /**
     * @return string
     */
    public function refreshToken()
    {
        if ($this->auth->isAccessTokenExpired()) {
            $this->auth->refreshTokenWithAssertion();
        }

        return $this->auth->getAccessToken();
    }
}