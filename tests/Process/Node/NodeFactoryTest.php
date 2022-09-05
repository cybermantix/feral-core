<?php

namespace Tests\Unit\Process\Node;

use NoLoCo\Core\Process\Context\ContextInterface;
use NoLoCo\Core\Process\NodeCode\AbstractNodeCode;
use NoLoCo\Core\Process\NodeCode\NodeFactory;
use NoLoCo\Core\Process\NodeCode\NodeRegistryItem;
use NoLoCo\Core\Process\Result\ResultInterface;
use NoLoCo\Core\Utility\Search\DataPathReader;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class NodeFactoryTest extends TestCase
{
    protected NodeFactory $factory;

    protected function setUp(): void
    {
        $mockContainer = $this->createmock(ContainerInterface::class);
        $mockContainer->method('get')->willReturn(new TestNode(new DataPathReader()));
        $this->factory = new NodeFactory($mockContainer, []);
    }

    public function testBuild()
    {
        $this->factory->addRegistryItem(
            (new NodeRegistryItem())
                ->setAlias('test')
                ->setFqcn('\Tests\Unit\Process\Node\TestNode')
                ->setConfiguration([
                    'one' => 1,
                    'two' => ['two' => 'three']
                ])
        );
        $node = $this->factory->build('test');
        $this->assertInstanceOf(TestNode::class, $node);

    }

    public function testAddRegistryItem()
    {
        $this->factory->addRegistryItem(
            (new NodeRegistryItem())
            ->setAlias('test')
            ->setFqcn('\Tests\Unit\Process\Node\TestNode')
            ->setConfiguration([
                'one' => 1,
                'two' => ['two' => 'three']
                ])
        );
        $this->factory->addRegistryItem(
            (new NodeRegistryItem())
                ->setAlias('test2')
                ->setFqcn('\Tests\Unit\Process\Node\TestNode')
                ->setConfiguration([
                    'one' => 2,
                    'two' => ['test' => 'four']
                ])
        );
        $node = $this->factory->build('test');
        $this->assertInstanceOf(TestNode::class, $node);
    }
}

class TestNode extends AbstractNodeCode
{
    /**
     * @inheritDoc
     */
    public function process(ContextInterface $context): ResultInterface
    {
        return $this->result('test', 'Just Testing');
    }
}

