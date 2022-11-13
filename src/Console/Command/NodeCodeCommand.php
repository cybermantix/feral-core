<?php

namespace NoLoCo\Core\Console\Command;

use DataObject\Configuration;
use NoLoCo\Core\Process\Catalog\Catalog;
use NoLoCo\Core\Process\NodeCode\NodeCodeFactory;
use NoLoCo\Core\Process\NodeCode\NodeCodeInterface;
use Reepository\ConfigurationRepository;
use Symfony\Component\Console\Attribute as Console;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[Console\AsCommand(
    name: 'noloco:node-code',
    description: 'List all of Node Codes on the platform'
)]
class NodeCodeCommand extends Command
{

    public function __construct(
        protected NodeCodeFactory $factory,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('NoLoCo Node Codes');
        $nodeCodes = $this->factory->getNodeCodes();
        $groups = [];
        foreach ($nodeCodes as $node) {
            $group = $node->getCategoryKey();
            if (empty($groups[$group])) {
                $groups[$group] = [];
            }
            $groups[$group][] = $node;
        }
        foreach ($groups as $key => $nodes) {
            $output->writeln(strtoupper($key));
            /** @var NodeCodeInterface $node */
            foreach ($nodes as $node) {
                $output->writeln(sprintf(" - %s <info>(%s)</info> : <comment>%s</comment>", $node->getName(), $node->getKey(), $node->getDescription()));
            }
            $output->writeln('');
        }

        return Command::SUCCESS;
    }
}