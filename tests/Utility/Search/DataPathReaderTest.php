<?php

namespace Tests\Unit\Search;

use Nodez\Core\Utility\Search\DataPathReader;
use PHPUnit\Framework\TestCase;

class DataPathReaderTest extends TestCase
{
    public function testGet()
    {
        $data = ['one-one' => ['two-one' => 'test1', 'two-two' => 'test2']];
        $reader = new DataPathReader();
        $value = $reader->getString($data,'one-one|two-one');
        $this->assertEquals('test1', $value);
    }

    public function testGetMultiple()
    {
        $data = ['one-one' => ['test' => ['test1', 'test2']]];
        $reader = new DataPathReader();
        $value = $reader->getArray($data,'one-one|test');
        $this->assertCount(2, $value);
    }

    public function testGetFromClass()
    {
        $class2 = new Temp();
        $class2->setData('testing');
        $class1 = new Temp();
        $class1->set('one', $class2);
        $reader = new DataPathReader();
        $value = $reader->getString($class1,'one|data');
        $this->assertEquals('testing', $value);
    }

    public function testGetFromArrayObject()
    {
        $class2 = new Temp();
        $class2->setData(1.0);
        $data = ['one-one' => ['test' => ['test1' => $class2, 'test2']]];
        $reader = new DataPathReader();
        $value = $reader->getFloat($data,'one-one|test|test1|data');
        $this->assertEquals(1.0, $value);
    }
}




class Temp
{
    protected string $data;

    protected array $testData;

    public function set(string $key, $data)
    {
        $this->testData[$key] = $data;
    }

    public function get(string $key)
    {
        if (isset($this->testData[$key])) {
            return $this->testData[$key];
        } else {
            return null;
        }
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }

    /**
     * @param string $data
     */
    public function setData(string $data): void
    {
        $this->data = $data;
    }
}
