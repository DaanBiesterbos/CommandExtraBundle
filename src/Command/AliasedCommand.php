<?php

/*
 * Command Extra Bundle
 *
 * Issues can be submitted here:
 * https://github.com/daanbiesterbos/CommandExtraBundle/issues
 */

namespace DaanBiesterbos\CommandExtraBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AliasedCommand.
 */
class AliasedCommand extends Command
{
    /**
     * @var array
     */
    protected $aliasConfig;

    /**
     * ConfigurableCommand constructor.
     *
     * @param array $aliasConfig
     * @param null  $name
     */
    public function __construct(array $aliasConfig, $name = null)
    {
        $this->aliasConfig = $aliasConfig;

        parent::__construct($name);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName($this->aliasConfig['name'])
            ->setDescription($this->aliasConfig['description']);
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $exitCode = 0;
        $cmdConfigs = $this->aliasConfig['execute'] ?? [];
        foreach ($cmdConfigs as $cmdConfig) {
            $exitCode = $this->runCommand($input, $output, $cmdConfig);
            if (0 !== $exitCode) {
                return $exitCode;
            }
        }

        return $exitCode;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @param array           $cmdConfig
     *
     * @return int
     */
    private function runCommand(InputInterface $input, OutputInterface $output, array $cmdConfig): int
    {
        $args = $cmdConfig['arguments'];
        if ($cmdConfig['symfony']) {
            $command = $this->getApplication()->find($cmdConfig['command']);
            array_unshift($args, $cmdConfig['command']);

            return $command->run(new ArrayInput($args), $output);
        }

        $exitCode = 0;
        passthru($cmdConfig['command'].' '.implode(' ', $args), $exitCode);

        return $exitCode;
    }
}
