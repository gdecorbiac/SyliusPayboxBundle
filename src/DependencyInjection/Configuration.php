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

        return $treeBuilder;
    }
}
