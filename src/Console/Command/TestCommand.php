<?php

namespace NoLoCo\Core\Console\Command;

use DataObject\Configuration;
use Reepository\ConfigurationRepository;
use Symfony\Component\Console\Attribute as Console;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[Console\AsCommand(
    name: 'noloco:test',
    description: 'Simple tests for NoLoCo'
)]
class TestCommand extends Command
{

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Starting Test');
        return Command::SUCCESS;
    }
}