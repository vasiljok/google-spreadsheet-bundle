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
     *
     * @param string $scope
     * @param string $clientEmail
     * @param string $privateKeyFile
     */
    public function __construct($scope, $clientEmail, $privateKeyFile)
    {
        if (!file_exists($privateKeyFile)) {
            throw new \InvalidArgumentException(sprintf('The file "%s" does not exist.', $privateKeyFile));
        }

        $privateKey = file_get_contents($privateKeyFile);
        $credentials = new Google_Auth_AssertionCredentials($clientEmail, array($scope), $privateKey);

        $this->client = new Google_Client();
        $this->client->setAssertionCredentials($credentials);

        parent::__construct('');
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