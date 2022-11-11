<?php

namespace NoLoCo\Core\Console\Command;

use DataObject\Configuration;
use NoLoCo\Core\Process\Engine\ProcessEngine;
use NoLoCo\Core\Process\ProcessJsonHydrator;
use NoLoCo\Core\Process\Reader\DirectoryProcessReader;
use NoLoCo\Core\Process\Validator\ProcessValidator;
use Psr\EventDispatcher\EventDispatcherInterface;
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

    public function __construct(
        protected EventDispatcherInterface $eventDispatcher,
        protected ProcessEngine $engine,
        protected ProcessValidator $validator
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Test Point');
        $reader = new DirectoryProcessReader('var/processes', new ProcessJsonHydrator());
        $processes = $reader->getProcesses();
        $process = array_shift($processes);
        $errors = $this->validator->validate($process);
        if (!empty($errors)) {
            $output->writeln('ERRORS');
            foreach ($errors as $error) {
                $output->writeln(sprintf('<error>%s</error>', $error));
            }
            return Command::FAILURE;
        }

        $this->engine->process($process);
        //$context = $process->getContext();
        $output->writeln('Done!');
        //$output->writeln('Context: ' . print_r($context, true));
        return Command::SUCCESS;
    }
}