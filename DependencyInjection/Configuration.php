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
                        ->defaultValue('https://spreadsheets.google.com/feeds')
                    ->end()
                    ->scalarNode('client_email')
                        ->info('The email address of your client user to authorize with via Google\'s OAuth2')
                        ->isRequired()
                        ->cannotBeEmpty()
                    ->end()
                    ->scalarNode('private_key')
                        ->info('The private key file to use for Google\'s OAuth2 authorization')
                        ->isRequired()
                        ->cannotBeEmpty()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
