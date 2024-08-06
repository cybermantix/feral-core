<?php

namespace Feral\Core\Process\Catalog\CatalogSource;

use Feral\Core\Process\Catalog\CatalogSource\AttributeCatalogNodeBuilder;
use Feral\Core\Process\NodeCode\NodeCodeFactory;
use Feral\Core\Process\Attributes\CatalogNodeDecorator;
use ReflectionClass;

class AttributeCatalogSource implements CatalogSourceInterface
{
    public function __construct(
        private NodeCodeFactory $factory,
        private AttributeCatalogNodeBuilder $builder
    ){}

    public function getCatalogNodes(): array
    {
        $nodeCodes = $this->factory->getNodeCodes();
        $catalogNodes = [];

        foreach ($nodeCodes as $nodeCode) {
            $reflection = new ReflectionClass($nodeCode);
            foreach ($reflection->getAttributes(CatalogNodeDecorator::class) as $attribute) {
                /** @var CatalogNodeDecorator $decorator */
                $decorator = $attribute->newInstance();
                $catalogNode = $this->builder->init()
                    ->withNodeCodeKey($nodeCode->getKey())
                    ->withCatalogNodeDecorator($decorator)
                    ->build();
                $catalogNodes[$catalogNode->getKey()] = $catalogNode;
            }
        }

        return $catalogNodes;
    }

}