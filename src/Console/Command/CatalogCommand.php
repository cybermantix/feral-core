<?php

namespace NoLoCo\Core\Console\Command;

use DataObject\Configuration;
use NoLoCo\Core\Process\Catalog\Catalog;
use Reepository\ConfigurationRepository;
use Symfony\Component\Console\Attribute as Console;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[Console\AsCommand(
    name: 'noloco:catalog',
    description: 'List all of the catalog nodes available on the platform.'
)]
class CatalogCommand extends Command
{

    public function __construct(
        protected Catalog $catalog,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('NoLoCo Catalog');
        $catalogNodes = $this->catalog->getCatalogNodes();
        $groups = [];
        foreach ($catalogNodes as $node) {
            $group = $node->getGroup();
            if (empty($groups[$group])) {
                $groups[$group] = [];
            }
            $groups[$group][] = $node;
        }
        foreach ($groups as $key => $nodes) {
            $output->writeln(strtoupper($key));
            foreach ($nodes as $node) {
                $output->writeln(sprintf(" - %s <info>(%s)</info> : <comment>%s</comment>", $node->getName(), $node->getKey(), $node->getDescription()));
            }
            $output->writeln('');
        }

        return Command::SUCCESS;
    }
}