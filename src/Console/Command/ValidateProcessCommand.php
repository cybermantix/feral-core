<?php

namespace NoLoCo\Core\Console\Command;

use DataObject\Configuration;
use NoLoCo\Core\Process\ProcessFactory;
use NoLoCo\Core\Process\ProcessJsonHydrator;
use NoLoCo\Core\Process\Validator\ProcessValidator;
use Reepository\ConfigurationRepository;
use Symfony\Component\Console\Attribute as Console;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[Console\AsCommand(
    name: 'noloco:validate:process',
    description: 'Validate a process which is defined as input via the argument or a file that contains the process.'
)]
class ValidateProcessCommand extends Command
{

    public function __construct(
        private ProcessFactory $factory,
        private ProcessJsonHydrator $hydrator,
        private ProcessValidator $validator
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('process', InputArgument::OPTIONAL, 'The JSON file or text to validate.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Validate a process');
        $json = $input->getArgument('process');
        if (empty($json)) {
            $output->writeln('Reading STDIN');
            $json = file_get_contents('php://stdin');
        }
        if (!is_null($json) && is_file($json)) {
            $output->writeln(sprintf('Reading file: "%s"', $json));
            $json = file_get_contents($json);
        }
        if (empty($json)) {
            $output->writeln('Invalid input');
            return Command::FAILURE;
        }
        // HYDRATE
        try {
            $process = $this->hydrator->hydrate($json);
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>Error hydrating Process. %s</error>', $e->getMessage()));
            return Command::FAILURE;
        }
        // VALIDATE
        $errors = $this->validator->validate($process);
        if (!empty($errors)) {
            foreach ($errors as $error) {
                $output->writeln(sprintf('<error>Error:</error> %s', $error));
            }
            return Command::FAILURE;
        } else {
            $output->writeln('The process is <info>valid</info>.');
            return Command::SUCCESS;
        }

    }
}