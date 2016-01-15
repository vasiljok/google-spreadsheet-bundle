<?php

namespace Wk\GoogleSpreadsheetBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionConfigurationTestCase;
use Wk\GoogleSpreadsheetBundle\DependencyInjection\Configuration;
use Wk\GoogleSpreadsheetBundle\DependencyInjection\WkGoogleSpreadsheetBundleExtension;

/**
 * Class ConfigurationTest
 */
class ConfigurationTest extends AbstractExtensionConfigurationTestCase
{
    public function testConfigurationFiles()
    {
        $expectedConfiguration = [
            'access_token' => 'token',
        ];

        $sources = [ __DIR__ . '/../Data/DependencyInjection/config.yml' ];

        $this->assertProcessedConfigurationEquals($expectedConfiguration, $sources);
    }

    /**
     * @inheritdoc
     */
    protected function getContainerExtension()
    {
        return new WkGoogleSpreadsheetBundleExtension();
    }

    /**
     * @inheritdoc
     */
    protected function getConfiguration()
    {
        return new Configuration();
    }
}
