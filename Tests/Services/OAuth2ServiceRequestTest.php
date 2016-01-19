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
     * testing if the credentials are correctly set in the google client
     */
    public function testSetCredentials() {
        $credentialsFile = __DIR__ . '/../Data/credentials.json';
        $scope = 'scope';
        $assertionCredentials = new Google_Auth_AssertionCredentials('test@test.com', array($scope), 'privatekey');

        $googleClientMock = $this->getMockBuilder('\Google_Client')
            ->disableOriginalConstructor()
            ->setMethods(array('loadServiceAccountJson', 'setAssertionCredentials'))
            ->getMock();

        $googleClientMock->expects($this->once())
            ->method('loadServiceAccountJson')
            ->with($credentialsFile)
            ->willReturn($assertionCredentials);

        $googleClientMock->expects($this->once())
            ->method('setAssertionCredentials')
            ->with($assertionCredentials);

        $oAuth2ServiceRequest = new OAuth2ServiceRequest();

        $oAuth2ServiceRequest->setClient($googleClientMock);

        $oAuth2ServiceRequest->setCredentials($credentialsFile, $scope);
    }

    /**
     * @return array
     */
    public function provideRefreshExpiredToken() {
        return array(
            array(false, 'accesstoken', file_get_contents(__DIR__ . '/../Data/accessToken.json')),
            array(false, null, null),
            array(true, 'accesstoken', file_get_contents(__DIR__ . '/../Data/accessToken.json')),
            array(true, null, null)
        );
    }

    /**
     * @param bool   $isAccessTokenExpired
     * @param string $expectedAccessToken
     * @param string $accessTokenJson
     *
     * @dataProvider provideRefreshExpiredToken
     */
    public function testRefreshExpiredToken($isAccessTokenExpired, $expectedAccessToken, $accessTokenJson) {
        $googleAuthMock = $this->getMockBuilder('\Google_Auth_OAuth2')
            ->disableOriginalConstructor()
            ->setMethods(array('isAccessTokenExpired', 'refreshTokenWithAssertion', 'getAccessToken'))
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
            ->setMethods(array('getAuth'))
            ->getMock();

        $googleClientMock->expects($this->any())
            ->method('getAuth')
            ->willReturn($googleAuthMock);

        $oAuth2ServiceRequest = new OAuth2ServiceRequest();

        $oAuth2ServiceRequest->setClient($googleClientMock);

        $actualAccessToken = $oAuth2ServiceRequest->refreshExpiredToken();

        $this->assertEquals($expectedAccessToken, $actualAccessToken);
    }
}