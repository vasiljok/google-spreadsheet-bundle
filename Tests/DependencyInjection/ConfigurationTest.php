<?php

namespace Wk\GoogleSpreadsheetBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionConfigurationTestCase;
use Wk\GoogleSpreadsheetBundle\DependencyInjection\Configuration;
use Wk\GoogleSpreadsheetBundle\DependencyInjection\WkGoogleSpreadsheetExtension;

/**
 * Class ConfigurationTest
 */
class ConfigurationTest extends AbstractExtensionConfigurationTestCase
{
    public function testConfigurationFiles()
    {
        $expectedConfiguration = [
            'scope' => 'testscope',
            'credentials_json_file' => 'credentials.json',
        ];

        $sources = [ __DIR__ . '/../Data/DependencyInjection/config.yml' ];

        $this->assertProcessedConfigurationEquals($expectedConfiguration, $sources);
    }

    /**
     * @inheritdoc
     */
    protected function getContainerExtension()
    {
        return new WkGoogleSpreadsheetExtension();
    }

    /**
     * @inheritdoc
     */
    protected function getConfiguration()
    {
        return new Configuration();
    }
}
