<?php

namespace Gontran\SyliusPayboxBundle\DependencyInjection;

use Gontran\SyliusPayboxBundle\PayboxParams;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('paybox');

        $rootNode->
            children()
                ->arrayNode('credentials')
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->children()
                        ->scalarNode('type')
                            ->isRequired()
                            ->cannotBeEmpty()
                            ->end()
                        ->scalarNode('rank')
                            ->isRequired()
                            ->cannotBeEmpty()
                            ->end()
                        ->scalarNode('identifier')
                            ->isRequired()
                            ->cannotBeEmpty()
                            ->end()
                        ->scalarNode('hmac')
                            ->isRequired()
                            ->cannotBeEmpty()
                            ->end()
                    ->end()
                ->end()
                ->arrayNode('servers')
                    ->cannotBeEmpty()
                    ->children()
                        ->arrayNode('classic')
                            ->children()
                                ->scalarNode('preprod')
                                    ->defaultValue(PayboxParams::SERVERS_CLASSIC_PREPROD)
                                    ->cannotBeEmpty()
                                    ->end()
                                ->arrayNode('prod')->prototype('scalar')
                                    ->defaultValue(PayboxParams::SERVERS_CLASSIC_PROD)
                                    ->cannotBeEmpty()
                                    ->end()
                            ->isRequired()
                            ->cannotBeEmpty()
                            ->end()
                        ->arrayNode('iframe')
                            ->children()
                                ->scalarNode('preprod')
                                    ->defaultValue(PayboxParams::SERVERS_IFRAME_PREPROD)
                                    ->cannotBeEmpty()
                                    ->end()
                                ->arrayNode('prod')->prototype('scalar')
                                    ->defaultValue(PayboxParams::SERVERS_IFRAME_PROD)
                                    ->cannotBeEmpty()
                                    ->end()
                            ->end()
                        ->arrayNode('mobile')
                            ->children()
                                ->scalarNode('preprod')
                                    ->defaultValue(PayboxParams::SERVERS_MOBILE_PREPROD)
                                    ->cannotBeEmpty()
                                    ->end()
                                ->arrayNode('prod')->prototype('scalar')
                                    ->defaultValue(PayboxParams::SERVERS_MOBILE_PROD)
                                    ->cannotBeEmpty()
                                    ->end()
                            ->end()
                    ->end()
                ->end()
                ->scalarNode('return_format')
                    ->defaultValue(PayboxParams::RETURN_FORMAT)
                    ->cannotBeEmpty()
                    ->end()
                ->booleanNode('sandbox')
                    ->defaultTrue()
                    ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
