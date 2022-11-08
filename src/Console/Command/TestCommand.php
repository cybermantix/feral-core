<?php

namespace NoLoCo\Core\Console\Command;

use DataObject\Configuration;
use NoLoCo\Core\Process\Catalog\Catalog;
use NoLoCo\Core\Process\Catalog\CatalogSource\TaggedCatalogSource;
use NoLoCo\Core\Process\Context\Context;
use NoLoCo\Core\Process\Edge\Edge;
use NoLoCo\Core\Process\Engine\ProcessEngine;
use NoLoCo\Core\Process\NodeCode\Flow\ContextValueComparatorNodeCode;
use NoLoCo\Core\Process\NodeCode\Flow\StartProcessingNode;
use NoLoCo\Core\Process\NodeCode\Flow\StopProcessingNode;
use NoLoCo\Core\Utility\Filter\Criterion;
use Psr\EventDispatcher\EventDispatcherInterface;
use Reepository\ConfigurationRepository;
use Symfony\Component\Console\Attribute as Console;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Stopwatch\Stopwatch;

#[Console\AsCommand(
    name: 'noloco:test',
    description: 'Simple tests for NoLoCo'
)]
class TestCommand extends Command
{

    public function __construct(
        private Catalog $catalog,
        protected EventDispatcherInterface $eventDispatcher
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Test Point');

        $catalogNodes = $this->catalog->getCatalogNodes();
        foreach ($catalogNodes as $node) {
            $output->writeln('Key: ' . $node->getKey());
        }
        $output->writeln('Count: ' . count($catalogNodes));
        return Command::SUCCESS;
    }
}