<?php

namespace Wk\GoogleSpreadsheetBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder
            ->root('wk_google_spreadsheet')
            ->children()
                ->scalarNode('scope')
                    ->info('Scope for Google\'s OAuth2 Authorization')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('credentials_json_file')
                    ->info('JSON file containing credentials for Google\'s OAuth2 Authorization')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
