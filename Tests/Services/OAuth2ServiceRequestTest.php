<?php

namespace Wk\GoogleSpreadsheetBundle\Tests\Services;

use \PHPUnit_Framework_TestCase;
use Wk\GoogleSpreadsheetBundle\Services\OAuth2ServiceRequest;
use \Google_Auth_AssertionCredentials;

/**
 * Class OAuth2ServiceRequestTest
 * @package Wk\GoogleSpreadsheetBundle\Tests\Services
 */
class OAuth2ServiceRequestTest extends PHPUnit_Framework_TestCase
{
    /**
     * Tests if an exception is thrown if the file doesn't exist
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The file "private_key" does not exist.
     */
    public function testConstructorFileException()
    {
        new OAuth2ServiceRequest('scope', 'client_email', 'private_key');
    }

    /**
     * testing if the credentials are correctly set in the google client
     */
    public function testConstructor()
    {
        $scope = 'scope';
        $clientEmail = 'client email';
        $privateKey = 'google_spreadsheet.credentials.private_key';
        $privateKeyFile = __DIR__ . '/../../App/private.key';

        $assertionCredentials = new Google_Auth_AssertionCredentials($clientEmail, [$scope], $privateKey);
        $expectedClient = new \Google_Client();
        $expectedClient->setAssertionCredentials($assertionCredentials);

        $oAuth2ServiceRequest = new OAuth2ServiceRequest($scope, $clientEmail, $privateKeyFile);

        $clientReflection = new \ReflectionProperty(OAuth2ServiceRequest::class, 'client');
        $clientReflection->setAccessible(true);

        /** @var \Google_Client $client */
        $client = $clientReflection->getValue($oAuth2ServiceRequest);
        $this->assertInstanceOf(\Google_Client::class, $client);
        $this->assertEquals($expectedClient, $client);
    }

    /**
     * @return array
     */
    public function provideRefreshExpiredToken()
    {
        return [
            [false, 'accesstoken', file_get_contents(__DIR__ . '/../Data/accessToken.json')],
            [false, null, null],
            [true, 'accesstoken', file_get_contents(__DIR__ . '/../Data/accessToken.json')],
            [true, null, null]
        ];
    }

    /**
     * @param bool   $isAccessTokenExpired
     * @param string $expectedAccessToken
     * @param string $accessTokenJson
     *
     * @dataProvider provideRefreshExpiredToken
     */
    public function testRefreshExpiredToken($isAccessTokenExpired, $expectedAccessToken, $accessTokenJson)
    {
        $googleAuthMock = $this->getMockBuilder('\Google_Auth_OAuth2')
            ->disableOriginalConstructor()
            ->setMethods(['isAccessTokenExpired', 'refreshTokenWithAssertion', 'getAccessToken'])
            ->getMock();

        $googleAuthMock->expects($this->once())
            ->method('isAccessTokenExpired')
            ->willReturn($isAccessTokenExpired);

        $googleAuthMock->expects($isAccessTokenExpired ? $this->once() : $this->never())
            ->method('refreshTokenWithAssertion');

        $googleAuthMock->expects($this->once())
            ->method('getAccessToken')
            ->willReturn($accessTokenJson);

        $googleClientMock = $this->getMockBuilder('\Google_Client')
            ->disableOriginalConstructor()
            ->setMethods(['getAuth'])
            ->getMock();

        $googleClientMock->expects($this->any())
            ->method('getAuth')
            ->willReturn($googleAuthMock);

        $privateKeyFile = __DIR__ . '/../../App/private.key';
        $oAuth2ServiceRequest = new OAuth2ServiceRequest('scope', 'client_email', $privateKeyFile);

        $clientReflection = new \ReflectionProperty(OAuth2ServiceRequest::class, 'client');
        $clientReflection->setAccessible(true);
        $clientReflection->setValue($oAuth2ServiceRequest, $googleClientMock);

        $actualAccessToken = $oAuth2ServiceRequest->refreshExpiredToken();

        $this->assertEquals($expectedAccessToken, $actualAccessToken);
    }
}