<?php

namespace NoLoCo\Core\Console\Command;

use DataObject\Configuration;
use NoLoCo\Core\Process\ProcessFactory;
use NoLoCo\Core\Process\Validator\ProcessValidator;
use Reepository\ConfigurationRepository;
use Symfony\Component\Console\Attribute as Console;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[Console\AsCommand(
    name: 'noloco:validate:processes',
    description: 'Validate all of the processes or use a filter to match processes.'
)]
class ValidateProcessesCommand extends Command
{

    public function __construct(
        private ProcessFactory $factory,
        private ProcessValidator $validator
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('key', InputArgument::OPTIONAL, 'The Catalog Node Key?');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Validate a process');
        $key = $input->getArgument('key');
        $processes = $this->factory->getAllProcesses();
        $allErrors = [];
        foreach ($processes as $process) {
            $errors = $this->validator->validate($process);
            if (!empty($errors)) {
                $allErrors[$process->getKey()] = $errors;
            }
        }
        print_r($allErrors);
        return Command::SUCCESS;
    }
}