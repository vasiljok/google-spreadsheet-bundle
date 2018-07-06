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
     * @param string $scope
     * @param string $clientEmail
     * @param string $privateKeyFile
     */
    public function __construct($scope, $clientEmail, $privateKeyFile)
    {
        if (!file_exists($privateKeyFile)) {
            throw new \InvalidArgumentException(sprintf('The file "%s" does not exist.', $privateKeyFile));
        }

        $this->client = new Google_Client();
        $this->client->setAuthConfig($privateKeyFile);

        parent::__construct('');
    }

    /**
     * @return string|null
     */
    public function refreshExpiredToken()
    {
        if ($this->client->isAccessTokenExpired()) {
            $this->client->refreshTokenWithAssertion();
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
}
