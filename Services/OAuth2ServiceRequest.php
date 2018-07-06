<?php

namespace Wk\GoogleSpreadsheetBundle\Services;

use Google\Spreadsheet\DefaultServiceRequest;
use \Google_Client;

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
     * @param string $token
     * @param string $privateKeyFile
     */
    public function __construct($token, $privateKeyFile)
    {
        if (!file_exists($privateKeyFile)) {
            throw new \InvalidArgumentException(sprintf('The file "%s" does not exist.', $privateKeyFile));
        }

        $this->client = new Google_Client();
        $this->client->setAuthConfig($privateKeyFile);
        $this->client->setScopes(Google_Service_Sheets::SPREADSHEETS);
        $this->client->setAccessType('offline');

        parent::__construct($token);
    }

    /**
     * @return string|null
     */
    public function refreshExpiredToken()
    {
        if ($this->client->isAccessTokenExpired()) {
            $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
        }

        $accessTokenArray = $this->client->getAccessToken();

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

    /**
     * Get url for authorization
     * @return string
     */
    public function getAuthUrl()
    {
        return $this->client->createAuthUrl();
    }

    /**
     * @param string $authCode
     * @return string
     */
    public function fetchAccessTokenWithAuthCode($authCode)
    {
        return $this->client->fetchAccessTokenWithAuthCode($authCode);
    }
}
