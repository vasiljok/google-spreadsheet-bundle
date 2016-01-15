<?php

namespace Wk\GoogleSpreadsheetBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Wk\GoogleSpreadsheetBundle\DependencyInjection\WkGoogleSpreadsheetBundleExtension;

/**
 * Class WkGoogleSpreadsheetBundleExtensionTest
 */
class WkGoogleSpreadsheetBundleExtensionTest extends AbstractExtensionTestCase
{
    /**
     * Tests exception for parameter misconfiguration
     */
    public function testLoadParameterException()
    {
        $this->setExpectedException(InvalidConfigurationException::class, 'The child node "access_token" at path "wk_google_spreadsheet_bundle" must be configured.');

        $this->load([]);
    }

    /**
     * Tests the container extension
     */
    public function testLoadParameter()
    {
        $this->load([
            'access_token' => 'token',
        ]);

        $this->assertContainerBuilderHasParameter('wk_google_spreadsheet_bundle.access_token', 'token');
    }

    /**
     * @return array
     */
    protected function getContainerExtensions()
    {
        return array(
            new WkGoogleSpreadsheetBundleExtension()
        );
    }
}
