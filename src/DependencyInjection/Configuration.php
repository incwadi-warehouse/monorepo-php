<?php

namespace Baldeweg\Bundle\ExtraBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('baldeweg_extra');

        $treeBuilder->getRootNode()
            ->children()
            ->scalarNode('userclass')
            ->defaultValue('App\\Entity\\User')
            ->end()
            ->end();

        return $treeBuilder;
    }
}
