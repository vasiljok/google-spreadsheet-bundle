<?php

namespace Wk\GoogleSpreadsheetBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class WkGoogleSpreadsheetExtension
 *
 * @package WkGoogleSpreadsheetBundleExtension\DependencyInjection
 */
class WkGoogleSpreadsheetExtension extends Extension
{
    /**
     * @inheritdoc
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $config);

        $container->setParameter('wk_google_spreadsheet.credentials.scope', $config['credentials']['scope']);
        $container->setParameter('wk_google_spreadsheet.credentials.client_email', $config['credentials']['client_email']);
        $container->setParameter('wk_google_spreadsheet.credentials.private_key', $config['credentials']['private_key']);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
    }
}