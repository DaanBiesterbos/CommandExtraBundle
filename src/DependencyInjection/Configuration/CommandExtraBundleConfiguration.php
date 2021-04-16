<?php

namespace DaanBiesterbos\CommandExtraBundle\DependencyInjection\Configuration;

use DaanBiesterbos\CommandExtraBundle\Command\AliasedCommand;
use DaanBiesterbos\CommandExtraBundle\DependencyInjection\CommandExtraExtension;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class CommandExtraBundleConfiguration
 *
 * @package AppBundle\DependencyInjection\Configuration
 */
final class CommandExtraBundleConfiguration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(CommandExtraExtension::EXTENSION_ALIAS);
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('command_class')
                    ->defaultValue(AliasedCommand::class)
                ->end()
                ->arrayNode('aliases')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('name')
                                ->isRequired()
                                ->cannotBeEmpty()
                                ->info("The command name")
                            ->end()
                            ->scalarNode('description')
                                ->info("The command description")
                            ->end()
                            ->arrayNode('execute')
                                ->prototype('array')
                                    ->beforeNormalization()->ifString()->then(function ($cmd) {
                                        return [
                                            [
                                                'command' => $cmd,
                                                'symfony' => false,
                                                'arguments' => []
                                            ]
                                        ];
                                    })->end()
                                    ->requiresAtLeastOneElement()
                                    ->children()
                                        ->scalarNode('command')
                                            ->isRequired()
                                            ->cannotBeEmpty()
                                            ->info("Executable to run")
                                        ->end()
                                        ->arrayNode('arguments')
                                            ->prototype('scalar')
                                            ->info("Arguments to be passed to the command")
                                        ->end()
                                        ->booleanNode('symfony')
                                            ->defaultFalse()
                                            ->info("Mark this command as a Symfony command")
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
