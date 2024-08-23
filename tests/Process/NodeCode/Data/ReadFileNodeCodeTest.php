<?php

namespace Feral\Core\Tests\Process\NodeCode\Data;

use Feral\Core\Process\Context\Context;
use Feral\Core\Process\NodeCode\Data\ReadFileNodeCode;
use Feral\Core\Process\Result\Description\ResultDescriptionInterface;
use Feral\Core\Process\Result\ResultInterface;
use Feral\Core\Utility\Filesystem\FileWrapper;
use PHPUnit\Framework\TestCase;

class ReadFileNodeCodeTest extends TestCase
{
    public function testReadFile()
    {
        $node = $this->buildNode(true, true, true, 1024, 'This is a test');
        $node->addConfiguration(
            [
                ReadFileNodeCode::FILE => 'test.csv',
                ReadFileNodeCode::CONTEXT_PATH => 'data',
                ReadFileNodeCode::MAXIMUM_SIZE => 1024 ** 2,
            ]
        );

        $context = (new Context());
        $result = $node->process($context);
        $this->assertEquals(ResultInterface::OK, $result->getStatus());
        $this->assertEquals('This is a test', $context->getString('data'));
    }

    public function testNoFile()
    {
        $node = $this->buildNode(false, true, true, 1024, 'This is a test');
        $node->addConfiguration(
            [
                ReadFileNodeCode::FILE => 'test.csv',
                ReadFileNodeCode::CONTEXT_PATH => 'data',
                ReadFileNodeCode::MAXIMUM_SIZE => 1024 ** 2,
            ]
        );

        $context = (new Context());
        $this->expectException(\Exception::class, 'File path "test.csv" does not exist.');
        $result = $node->process($context);
        $this->assertEquals(ResultInterface::OK, $result->getStatus());
    }

    public function testNotReadable()
    {
        $node = $this->buildNode(true, false, true, 1024, 'This is a test');
        $node->addConfiguration(
            [
                ReadFileNodeCode::FILE => 'test.csv',
                ReadFileNodeCode::CONTEXT_PATH => 'data',
                ReadFileNodeCode::MAXIMUM_SIZE => 1024 ** 2,
            ]
        );

        $context = (new Context());
        $this->expectException(\Exception::class, 'File path "test.csv" does not readable.');
        $result = $node->process($context);
        $this->assertEquals(ResultInterface::OK, $result->getStatus());
    }

    public function testToBig()
    {
        $node = $this->buildNode(true, true, true, 1024 * 2, 'This is a test');
        $node->addConfiguration(
            [
                ReadFileNodeCode::FILE => 'test.csv',
                ReadFileNodeCode::CONTEXT_PATH => 'data',
                ReadFileNodeCode::MAXIMUM_SIZE => 1024,
            ]
        );

        $context = (new Context());
        $this->expectException(\Exception::class, 'File "test.csv" is larger than the maximum filesize allowed "1024".');
        $result = $node->process($context);
        $this->assertEquals(ResultInterface::OK, $result->getStatus());
    }


    private function buildNode(bool $isFile, bool $isReadable, bool $isWritable, int $filesize, string $content): ReadFileNodeCode
    {
        $mockWrapper = $this->createMock(FileWrapper::class);
        $mockWrapper->method('isFile')->willReturn($isFile);
        $mockWrapper->method('isReadable')->willReturn($isReadable);
        $mockWrapper->method('isWritable')->willReturn($isWritable);
        $mockWrapper->method('getFilesize')->willReturn($filesize);
        $mockWrapper->method('getFileContents')->willReturn($content);
        return new ReadFileNodeCode(fileWrapper: $mockWrapper);
    }
}
