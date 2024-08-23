<?php

namespace Feral\Core\Tests\Process\NodeCode\Flow;

use Feral\Core\Process\Context\Context;
use Feral\Core\Process\Exception\ProcessException;
use Feral\Core\Process\NodeCode\Flow\ContextValueComparatorNodeCode;
use Feral\Core\Process\NodeCode\Flow\StartProcessingNode;
use Feral\Core\Process\NodeCode\Flow\ThrowExceptionNodeCode;
use Feral\Core\Process\Result\Description\ResultDescriptionInterface;
use Feral\Core\Process\Result\ResultInterface;
use Feral\Core\Utility\Filter\Criterion;
use PHPUnit\Framework\TestCase;

class ThrowExceptionNodeTest extends TestCase
{
    public function testProcess()
    {
        $context = new Context();
        $node = (new ThrowExceptionNodeCode())->addConfiguration(
            [
                ThrowExceptionNodeCode::MESSAGE => 'test',
            ]
        );
        $this->expectException(ProcessException::class);
        $this->expectExceptionMessage('test');
        $node->process($context);
    }
}

