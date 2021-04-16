<?php

/*
 * Command Extra Bundle
 *
 * Issues can be submitted here:
 * https://github.com/daanbiesterbos/CommandExtraBundle/issues
 */

namespace DaanBiesterbos\CommandExtraBundle\DependencyInjection;

use DaanBiesterbos\CommandExtraBundle\Command\AliasedCommand;
use DaanBiesterbos\CommandExtraBundle\DependencyInjection\Configuration\CommandExtraBundleConfiguration;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;

/**
 * Class CommandExtraExtension.
 */
final class CommandExtraExtension extends Extension
{
    public const EXTENSION_ALIAS = 'command_extra';

    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new CommandExtraBundleConfiguration();
        $config = $this->processConfiguration($configuration, $configs);
        $class = $config['command_class'] ?? AliasedCommand::class;

        foreach ($config['aliases'] as $key => $aliasConfig) {
            $command = new Definition($class, [$aliasConfig, $aliasConfig['name']]);
            $command->addTag('console.command');
            $container->setDefinition($key, $command);
        }
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return self::EXTENSION_ALIAS;
    }
}
