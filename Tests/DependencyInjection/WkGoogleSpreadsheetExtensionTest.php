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
     * @return array
     */
    public function provideLoadParameterException() {
        return array(
            array(array('scope' => 'testscope'), 'The child node "credentials_json_file" at path "wk_google_spreadsheet" must be configured.'),
            array(array('credentials_json_file' => 'credentials.json'), 'The child node "scope" at path "wk_google_spreadsheet" must be configured.')
        );
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
        $this->load([
            'scope' => 'testscope',
            'credentials_json_file' => 'credentials.json',
        ]);

        $this->assertContainerBuilderHasParameter('wk_google_spreadsheet.scope', 'testscope');
        $this->assertContainerBuilderHasParameter('wk_google_spreadsheet.credentials_json_file', 'credentials.json');
    }

    /**
     * @return array
     */
    protected function getContainerExtensions()
    {
        return array(
            new WkGoogleSpreadsheetExtension()
        );
    }
}
