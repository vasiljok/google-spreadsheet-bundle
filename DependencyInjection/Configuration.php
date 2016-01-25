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
                ->arrayNode('credentials')
                ->isRequired()
                ->cannotBeEmpty()
                ->children()
                    ->scalarNode('scope')
                        ->info('Scope for Google\'s OAuth2 Authorization')
                        ->isRequired()
                        ->cannotBeEmpty()
                    ->end()
                    ->scalarNode('client_email')
                        ->info('The field client_email from your credentials for Google\'s OAuth2 Authorization')
                        ->isRequired()
                        ->cannotBeEmpty()
                    ->end()
                    ->scalarNode('private_key')
                        ->info('The field private_key from your credentials for Google\'s OAuth2 Authorization')
                        ->isRequired()
                        ->cannotBeEmpty()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
