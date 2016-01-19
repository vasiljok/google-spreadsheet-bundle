<?php

namespace Wk\GoogleSpreadsheetBundle\Model;

use \Google_Client;
use \Google_Auth_OAuth2;

/**
 * Class OAuth2Client
 * @package Wk\GoogleSpreadsheetBundle\Services
 */
class OAuth2Client
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
     * @return string|null
     */
    public function refreshToken()
    {
        if ($this->auth->isAccessTokenExpired()) {
            $this->auth->refreshTokenWithAssertion();
        }

        return $this->extractAccessToken();
    }

    /**
     * @return string|null
     */
    private function extractAccessToken() {
        $accessTokenArray = json_decode($this->auth->getAccessToken(), true);

        return isset($accessTokenArray['access_token']) ? $accessTokenArray['access_token'] : null;
    }
}