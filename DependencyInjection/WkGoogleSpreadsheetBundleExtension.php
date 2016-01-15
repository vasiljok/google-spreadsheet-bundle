<?php

namespace Wk\GoogleSpreadsheetBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class WkGoogleSpreadsheetBundleExtension
 *
 * @package WkGoogleSpreadsheetBundleExtension\DependencyInjection
 */
class WkGoogleSpreadsheetBundleExtension extends Extension
{
    /**
     * @inheritdoc
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $config);

        $container->setParameter('wk_google_spreadsheet_bundle.access_token', $config['access_token']);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
    }
}