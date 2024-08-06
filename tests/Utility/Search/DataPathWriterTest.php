<?php

namespace Feral\Core\Tests\Utility\Search;

use Feral\Core\Utility\Search\DataPathWriter;
use PHPUnit\Framework\TestCase;

class DataPathWriterTest extends TestCase
{

    public function testSet()
    {
        $writer = new DataPathWriter();
        $data = $writer->set([], 1, 'one');
        $this->assertEquals(1, $data['one']);
    }

    public function testDeepSet()
    {
        $writer = new DataPathWriter();
        $data = $writer->set(
            [
                'one' => [
                    'two' => [
                        'three' => []
                    ]
                ]
            ]
            , 1,
            'one|two|three|four'
        );
        $this->assertEquals(1, $data['one']['two']['three']['four']);
    }

    public function testObject()
    {
        $writer = new DataPathWriter();
        $data = (new TestData())
            ->setOne('test')
            ->setTwo([
                'three' => []
            ]);

        /** @var TestData $data */
        $data = $writer->set($data, 1, 'two|three|four');
        $this->assertEquals(1, $data->getTwo()['three']['four']);
    }

    public function testComplexObject()
    {
        $writer = new DataPathWriter();
        $data = (new TestData())
            ->setOne('test')
            ->setTwo([
                'three' => [
                    'four' => (new TestData())
                ]
            ]);

        /** @var TestData $data */
        $data = $writer->set($data, ['five' => 1], 'two|three|four|two');
        $this->assertEquals(1, $data->getTwo()['three']['four']->getTwo()['five']);
    }

    public function testObjectWithGet()
    {
        $writer = new DataPathWriter();
        $data = (new TestDataGet())->set('one', []);

        /** @var TestData $data */
        $data = $writer->set($data, 1, 'one|two');
        $this->assertEquals(1, $data->get('one')['two']);
    }
}

class TestData {
    protected string $one = '';

    protected array $two = [];

    /**
     * @return string
     */
    public function &getOne(): string
    {
        return $this->one;
    }

    /**
     * @param string $one
     * @return TestData
     */
    public function setOne(string $one): TestData
    {
        $this->one = $one;
        return $this;
    }

    /**
     * @return array
     */
    public function &getTwo(): array
    {
        return $this->two;
    }

    /**
     * @param array $two
     * @return TestData
     */
    public function setTwo(array $two): TestData
    {
        $this->two = $two;
        return $this;
    }
}

class TestDataGet {
    protected array $data = [];
    public function set(string $key, mixed $value): static
    {
        $this->data[$key] = $value;
        return $this;
    }
    public function &get($key): mixed
    {
        return $this->data[$key];
    }
}
