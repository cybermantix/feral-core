<?php

namespace Feral\Core\Tests\Process\NodeCode\Data;

use Feral\Core\Process\Context\Context;
use Feral\Core\Process\NodeCode\Data\RandomValueNodeCode;
use Feral\Core\Process\Result\ResultInterface;
use PHPUnit\Framework\TestCase;

class RandomValueNodeCodeTest extends TestCase
{

    private RandomValueNodeCode $node;

    protected function setUp(): void
    {
        $this->node = new RandomValueNodeCode();
    }

    public function testProcess()
    {
        $this->node->addConfiguration([
            RandomValueNodeCode::CONTEXT_PATH => 'random'
        ]);
        $context = (new Context());
        $result = $this->node->process($context);
        $this->assertEquals(ResultInterface::OK, $result->getStatus());
        $this->assertNotEmpty($context->get('random'));
    }

    public function testGetConfigurationDescriptions()
    {
        $configuration = $this->node->getConfigurationDescriptions();
        $this->assertEquals(1, count($configuration));
    }
}
