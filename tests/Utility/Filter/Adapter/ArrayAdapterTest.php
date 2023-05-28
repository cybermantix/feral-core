<?php

namespace Feral\Core\Tests\Utility\Filter\Adapter;

use Feral\Core\Utility\Filter\Adapter\ArrayAdapter;
use Feral\Core\Utility\Filter\Exception\CriterionException;
use Feral\Core\Utility\Filter\FilterBuilder;
use PHPUnit\Framework\TestCase;

class ArrayAdapterTest extends TestCase
{

    /**
     * @throws CriterionException
     */
    public function testApply()
    {
        //$this->markTestSkipped('Need to fix the Array Adapter to filter an array.');
        $filter = (new FilterBuilder())
            ->init()
            ->equal('test', ['one', 'two', 'three'])
            ->build();
        $adapter = new ArrayAdapter();
        $adapter->setArray(['one', 'two', 'three']);
        $adapter->apply($filter);
        $adaptedScalar = $adapter->getArray();
        $this->assertEquals(['one', 'two', 'three'], $adaptedScalar);

        $filter = (new FilterBuilder())
            ->init()
            ->equal('test', ['two', 'three'])
            ->build();
        $adapter = new ArrayAdapter();
        $adapter->setArray(['one']);
        $adapter->apply($filter);
        $adaptedScalar = $adapter->getArray();
        $this->assertNull($adaptedScalar);
    }

    /**
     * @throws CriterionException
     */
    public function testApplyAnd()
    {
        //$this->markTestSkipped('Need to fix the Array Adapter to filter an array.');
        $filter = (new FilterBuilder())
            ->init()
            ->equal('test', ['one', 'two', 'three'])
            ->equal('second', ['one', 'two', 'three'])
            ->build();
        $adapter = new ArrayAdapter();
        $adapter->setArray(['one', 'two', 'three']);
        $adapter->apply($filter);
        $adaptedScalar = $adapter->getArray();
        $this->assertEquals(['one', 'two', 'three'], $adaptedScalar);

        $filter = (new FilterBuilder())
            ->init()
            ->equal('test', ['one', 'two', 'three'])
            ->equal('second', ['two', 'three'])
            ->build();
        $adapter = new ArrayAdapter();
        $adapter->setArray(['one']);
        $adapter->apply($filter);
        $adaptedScalar = $adapter->getArray();
        $this->assertNull($adaptedScalar);
    }

    /**
     * @throws CriterionException
     */
    public function testApplyOr()
    {
        //$this->markTestSkipped('Need to fix the Array Adapter to filter an array.');
        $filter = (new FilterBuilder())
            ->init()
            ->equal('test', ['one', 'two', 'three'])
            ->equal('test', ['one', 'three'])
            ->build();
        $adapter = new ArrayAdapter();
        $adapter->setArray(['one', 'two', 'three']);
        $adapter->apply($filter);
        $adaptedScalar = $adapter->getArray();
        $this->assertEquals(['one', 'two', 'three'], $adaptedScalar);

        $filter = (new FilterBuilder())
            ->init()
            ->equal('test', ['one', 'three'])
            ->equal('test', ['one', 'two'])
            ->build();
        $adapter = new ArrayAdapter();
        $adapter->setArray(['four']);
        $adapter->apply($filter);
        $adaptedScalar = $adapter->getArray();
        $this->assertNull($adaptedScalar);
    }

    /**
     */
    public function testApplyWithIn()
    {
        //$this->markTestSkipped('Need to fix the Array Adapter to filter an array.');
        $filter = (new FilterBuilder())
            ->init()
            ->in('one', ['one', 'two', 'three'])
            ->build();
        $adapter = new ArrayAdapter();
        $adapter->setArray(['one']);
        $adapter->apply($filter);
        $adaptedScalar = $adapter->getArray();
        $this->assertEquals(['one'], $adaptedScalar);
    }

    /**
     */
    public function testApplyWithNotIn()
    {
        //$this->markTestSkipped('Need to fix the Array Adapter to filter an array.');
        $filter = (new FilterBuilder())
            ->init()
            ->notIn('one', ['one', 'three'])
            ->build();
        $adapter = new ArrayAdapter();
        $adapter->setArray(['two']);
        $adapter->apply($filter);
        $adaptedScalar = $adapter->getArray();
        $this->assertEquals(['two'], $adaptedScalar);

        $filter = (new FilterBuilder())
            ->init()
            ->notIn('one', ['one', 'three'])
            ->build();
        $adapter = new ArrayAdapter();
        $adapter->setArray(['one']);
        $adapter->apply($filter);
        $adaptedScalar = $adapter->getArray();
        $this->assertNull($adaptedScalar);
    }
}
