<?php

namespace Wk\GoogleSpreadsheetBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Wk\GoogleSpreadsheetBundle\DependencyInjection\WkGoogleSpreadsheetExtension;

/**
 * Class WkGoogleSpreadsheetBundleExtensionTest
 */
class WkGoogleSpreadsheetExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @var array
     */
    private $config;

    /**
     * set up config
     */
    protected function setUp()
    {
        parent::setUp();

        $this->config = [
            'credentials' => [
                'scope'        => 'testscope',
                'client_email' => 'client email',
                'private_key'  => 'private key',
            ],
        ];
    }

    /**
     * @return array
     */
    public function provideLoadParameterException()
    {
        return [
            [[], 'The child node "credentials" at path "wk_google_spreadsheet" must be configured.'],
            [
                ['credentials' => ['scope' => 'testscope']],
                'The child node "client_email" at path "wk_google_spreadsheet.credentials" must be configured.',
            ],
            [
                ['credentials' => ['scope' => 'testscope', 'client_email' => 'client email']],
                'The child node "private_key" at path "wk_google_spreadsheet.credentials" must be configured.',
            ],
        ];
    }

    /**
     * Tests exception for parameter misconfiguration
     *
     * @param array  $parameters
     * @param string $exceptionMessage
     *
     * @dataProvider provideLoadParameterException
     */
    public function testLoadParameterException(array $parameters, $exceptionMessage)
    {
        $this->setExpectedException(InvalidConfigurationException::class, $exceptionMessage);

        $this->load($parameters);
    }

    /**
     * Tests the container extension
     */
    public function testLoadParameter()
    {
        $this->load($this->config);

        $this->assertContainerBuilderHasParameter('wk_google_spreadsheet.credentials.scope', 'testscope');
        $this->assertContainerBuilderHasParameter('wk_google_spreadsheet.credentials.client_email', 'client email');
        $this->assertContainerBuilderHasParameter('wk_google_spreadsheet.credentials.private_key', 'private key');
    }

    /**
     * Test that the services exist in the container
     */
    public function testLoadContainer()
    {
        $this->load($this->config);

        $wkGoogleSpreadsheet = 'wk_google_spreadsheet';
        $wkGoogleOAuth2ForSpreadsheets = 'wk_google_oauth2_for_spreadsheets';

        $this->assertContainerBuilderHasService($wkGoogleSpreadsheet, 'Wk\GoogleSpreadsheetBundle\Services\SpreadsheetService');
        $this->assertContainerBuilderHasServiceDefinitionWithArgument($wkGoogleSpreadsheet, 0, $wkGoogleOAuth2ForSpreadsheets);

        $this->assertContainerBuilderHasService($wkGoogleOAuth2ForSpreadsheets, 'Wk\GoogleSpreadsheetBundle\Services\OAuth2ServiceRequest');
        $this->assertContainerBuilderHasServiceDefinitionWithArgument($wkGoogleOAuth2ForSpreadsheets, 0, '%wk_google_spreadsheet.credentials.scope%');
        $this->assertContainerBuilderHasServiceDefinitionWithArgument($wkGoogleOAuth2ForSpreadsheets, 1, '%wk_google_spreadsheet.credentials.client_email%');
        $this->assertContainerBuilderHasServiceDefinitionWithArgument($wkGoogleOAuth2ForSpreadsheets, 2, '%wk_google_spreadsheet.credentials.private_key%');
    }

    /**
     * @return array
     */
    protected function getContainerExtensions()
    {
        return [
            new WkGoogleSpreadsheetExtension(),
        ];
    }
}
