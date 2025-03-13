<?php

namespace Feral\Core\Process;

use Feral\Core\Process\Context\ContextInterface;
use Feral\Core\Process\Edge\EdgeInterface;
use Feral\Core\Process\Node\NodeInterface;

/**
 * The concrete process.
 *
 * @see ProcessInterface
 */
class Process implements ProcessInterface
{
    /**
     * @var string
     */
    protected string $key;
    /**
     * @var string
     */
    protected string $description = '';
    /**
     * @var ContextInterface
     */
    protected ContextInterface $context;
    /**
     * @var NodeInterface[]
     */
    protected array $nodes;
    /**
     * @var EdgeInterface[]
     */
    protected array $edges;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param  string $key
     * @return Process
     */
    public function setKey(string $key): Process
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Process
     */
    public function setDescription(string $description): Process
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return ContextInterface
     */
    public function getContext(): ContextInterface
    {
        return $this->context;
    }

    /**
     * @param  ContextInterface $context
     * @return Process
     */
    public function setContext(ContextInterface $context): static
    {
        $this->context = $context;
        return $this;
    }

    /**
     * @return NodeInterface[]
     */
    public function getNodes(): array
    {
        return $this->nodes;
    }

    /**
     * @param  NodeInterface[] $nodes
     * @return Process
     */
    public function setNodes(array $nodes): static
    {
        $this->nodes = $nodes;
        return $this;
    }

    /**
     * @return EdgeInterface[]
     */
    public function getEdges(): array
    {
        return $this->edges;
    }

    /**
     * @param  EdgeInterface[] $edges
     * @return Process
     */
    public function setEdges(array $edges): static
    {
        $this->edges = $edges;
        return $this;
    }
}
