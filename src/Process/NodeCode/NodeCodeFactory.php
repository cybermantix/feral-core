<?php

namespace NoLoCo\Core\Process\NodeCode;

use NoLoCo\Core\Process\NodeCode\NodeCodeSource\NodeCodeSourceInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

class NodeCodeFactory
{
    /**
     * @var NodeCodeInterface[]
     */
    protected array $nodeCodes = [];

    public function __construct(
        #[TaggedIterator('noloco.node_code_source')] iterable $sources
    )
    {
        /** @var NodeCodeSourceInterface $source */
        foreach ($sources as $source) {
            foreach ($source->getNodeCodes() as $nodeCode) {
                $key = $nodeCode->getKey();
                if (!empty($key)) {
                    $this->nodeCodes[$key] = $nodeCode;
                }
            }
        }
    }

    /**
     * @param string $key
     * @return NodeCodeInterface
     */
    public function getNodeCode(string $key): NodeCodeInterface
    {
        return $this->nodeCodes[$key];
    }

    /**
     * @return NodeCodeInterface[]
     */
    public function getNodeCodes(): array
    {
        return $this->nodeCodes;
    }
}