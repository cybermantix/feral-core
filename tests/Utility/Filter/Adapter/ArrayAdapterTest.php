<?php

namespace Nodez\Core\Tests\Utility\Filter\Adapter;

use Nodez\Core\Utility\Filter\Adapter\ArrayAdapter;
use Nodez\Core\Utility\Filter\Exception\CriterionException;
use Nodez\Core\Utility\Filter\FilterBuilder;
use PHPUnit\Framework\TestCase;

class ArrayAdapterTest extends TestCase
{

    /**
     * @throws CriterionException
     */
    public function testApply()
    {
        $this->markTestSkipped('Need to fix the Array Adapter to filter an array.');
        $filter = (new FilterBuilder())
            ->init()
            ->equal('test', ['one', 'two', 'three'])
            ->build();
        $adapter = new ArrayAdapter();
        $adapter->setArray(['one', 'two', 'three']);
        $adapter->apply($filter);
        $adaptedScalar = $adapter->getArray();
        $this->assertEquals('one', $adaptedScalar);

        $filter = (new FilterBuilder())
            ->init()
            ->equal('test', ['two', 'three'])
            ->build();
        $adapter = new ArrayAdapter();
        $adapter->setArray('one');
        $adapter->apply($filter);
        $adaptedScalar = $adapter->getArray();
        $this->assertNull($adaptedScalar);
    }

    /**
     * @throws CriterionException
     */
    public function testApplyAnd()
    {
        $this->markTestSkipped('Need to fix the Array Adapter to filter an array.');
        $filter = (new FilterBuilder())
            ->init()
            ->equal('test', ['one', 'two', 'three'])
            ->equal('second', ['one', 'two', 'three'])
            ->build();
        $adapter = new ArrayAdapter();
        $adapter->setArray(['one', 'two', 'three']);
        $adapter->apply($filter);
        $adaptedScalar = $adapter->getArray();
        $this->assertEquals('one', $adaptedScalar);

        $filter = (new FilterBuilder())
            ->init()
            ->equal('test', ['one', 'two', 'three'])
            ->equal('second', ['two', 'three'])
            ->build();
        $adapter = new ArrayAdapter();
        $adapter->setArray('one');
        $adapter->apply($filter);
        $adaptedScalar = $adapter->getArray();
        $this->assertNull($adaptedScalar);
    }

    /**
     * @throws CriterionException
     */
    public function testApplyOr()
    {
        $this->markTestSkipped('Need to fix the Array Adapter to filter an array.');
        $filter = (new FilterBuilder())
            ->init()
            ->equal('test', ['one', 'two', 'three'])
            ->equal('test', ['one', 'three'])
            ->build();
        $adapter = new ArrayAdapter();
        $adapter->setArray(['one', 'two', 'three']);
        $adapter->apply($filter);
        $adaptedScalar = $adapter->getArray();
        $this->assertEquals('one', $adaptedScalar);

        $filter = (new FilterBuilder())
            ->init()
            ->equal('test', ['one', 'three'])
            ->equal('test', ['one', 'two'])
            ->build();
        $adapter = new ArrayAdapter();
        $adapter->setArray('one');
        $adapter->apply($filter);
        $adaptedScalar = $adapter->getArray();
        $this->assertNull($adaptedScalar);
    }

    /**
     */
    public function testApplyWithIn()
    {
        $this->markTestSkipped('Need to fix the Array Adapter to filter an array.');
        $filter = (new FilterBuilder())
            ->init()
            ->in('one', ['one', 'two', 'three'])
            ->build();
        $adapter = new ArrayAdapter();
        $adapter->setArray('one');
        $adapter->apply($filter);
        $adaptedScalar = $adapter->getArray();
        $this->assertEquals('one', $adaptedScalar);

        $filter = (new FilterBuilder())
            ->init()
            ->in('one', ['two', 'three'])
            ->build();
        $adapter = new ArrayAdapter();
        $adapter->setArray('one');
        $adapter->apply($filter);
        $adaptedScalar = $adapter->getArray();
        $this->assertNull($adaptedScalar);
    }

    /**
     */
    public function testApplyWithNotIn()
    {
        $this->markTestSkipped('Need to fix the Array Adapter to filter an array.');
        $filter = (new FilterBuilder())
            ->init()
            ->notIn('one', ['two', 'three'])
            ->build();
        $adapter = new ArrayAdapter();
        $adapter->setArray('one');
        $adapter->apply($filter);
        $adaptedScalar = $adapter->getArray();
        $this->assertEquals('one', $adaptedScalar);

        $filter = (new FilterBuilder())
            ->init()
            ->notIn('one', ['one', 'three'])
            ->build();
        $adapter = new ArrayAdapter();
        $adapter->setArray('one');
        $adapter->apply($filter);
        $adaptedScalar = $adapter->getArray();
        $this->assertNull($adaptedScalar);
    }

    /**
     * @throws CriterionException
     */
    public function testApplyWithStartsWith()
    {
        $this->markTestSkipped('Need to fix the Array Adapter to filter an array.');
        $filter = (new FilterBuilder())
            ->init()
            ->startsWith('one', ['one', 'two'])
            ->build();
        $adapter = new ArrayAdapter();
        $adapter->setArray(['one', 'two', 'three']);
        $adapter->apply($filter);
        $adaptedScalar = $adapter->getArray();
        $this->assertEquals(['one', 'two', 'three'], $adaptedScalar);


        $filter = (new FilterBuilder())
            ->init()
            ->startsWith('one', ['two', 'three'])
            ->build();
        $adapter = new ArrayAdapter();
        $adapter->setArray(['one', 'two', 'three']);
        $adapter->apply($filter);
        $adaptedScalar = $adapter->getArray();
        $this->assertNull($adaptedScalar);


        $filter = (new FilterBuilder())
            ->init()
            ->startsWith('one', [1,2])
            ->build();
        $adapter = new ArrayAdapter();
        $adapter->setArray([1,2,3]);
        $adapter->apply($filter);
        $adaptedScalar = $adapter->getArray();
        $this->assertEquals([1,2,3], $adaptedScalar);

        $filter = (new FilterBuilder())
            ->init()
            ->startsWith('one', [2,3])
            ->build();
        $adapter = new ArrayAdapter();
        $adapter->setArray([7,8,9]);
        $adapter->apply($filter);
        $adaptedScalar = $adapter->getArray();
        $this->assertNull($adaptedScalar);
    }

    /**
     * @throws CriterionException
     */
    public function testApplyWithEndsWith()
    {
        $this->markTestSkipped('Need to fix the Array Adapter to filter an array.');
        $filter = (new FilterBuilder())
            ->init()
            ->endsWith('one', [2,3])
            ->build();
        $adapter = new ArrayAdapter();
        $adapter->setArray([1,2,3]);
        $adapter->apply($filter);
        $adaptedScalar = $adapter->getArray();
        $this->assertEquals([1,2,3], $adaptedScalar);


        $filter = (new FilterBuilder())
            ->init()
            ->endsWith('one', [7,8,9])
            ->build();
        $adapter = new ArrayAdapter();
        $adapter->setArray([1,2,3]);
        $adapter->apply($filter);
        $adaptedScalar = $adapter->getArray();
        $this->assertNull($adaptedScalar);
    }

    /**
     * @throws CriterionException
     */
    public function testApplyWithBetween()
    {
        $this->markTestSkipped('Need to fix the Array Adapter to filter an array.');
        $filter = (new FilterBuilder())
            ->init()
            ->between('one', '1|3')
            ->build();

        $adapter = new ArrayAdapter();
        $adapter->setArray([1,2,3]);
        $adapter->apply($filter);
        $adaptedScalar = $adapter->getArray();
        $this->assertEquals([1,2,3], $adaptedScalar);
    }

    /**
     * @throws CriterionException
     */
    public function testApplyWithLessThan()
    {
        $this->markTestSkipped('Need to fix the Array Adapter to filter an array.');
        $filter = (new FilterBuilder())
            ->init()
            ->lessThan('one', 4)
            ->build();
        $adapter = new ArrayAdapter();
        $adapter->setArray([1,2,3]);
        $adapter->apply($filter);
        $adaptedScalar = $adapter->getArray();
        $this->assertEquals([1,2,3], $adaptedScalar);


        $filter = (new FilterBuilder())
            ->init()
            ->lessThan('one', 2)
            ->build();
        $adapter = new ArrayAdapter();
        $adapter->setArray([1,2,3]);
        $adapter->apply($filter);
        $adaptedScalar = $adapter->getArray();
        $this->assertNull($adaptedScalar);
    }

    /**
     * @throws CriterionException
     */
    public function testApplyWithLessThanOrEqualTo()
    {
        $this->markTestSkipped('Need to fix the Array Adapter to filter an array.');
        $filter = (new FilterBuilder())
            ->init()
            ->lessThanOrEqualTo('one', 3)
            ->build();
        $adapter = new ArrayAdapter();
        $adapter->setArray([1,2,3]);
        $adapter->apply($filter);
        $adaptedScalar = $adapter->getArray();
        $this->assertEquals([1,2,3], $adaptedScalar);


        $filter = (new FilterBuilder())
            ->init()
            ->lessThanOrEqualTo('one', 2)
            ->build();
        $adapter = new ArrayAdapter();
        $adapter->setArray([1,2,3]);
        $adapter->apply($filter);
        $adapted = $adapter->getArray();
        $this->assertNull($adapted);
    }

    /**
     * @throws CriterionException
     */
    public function testApplyWithGreaterThan()
    {
        $this->markTestSkipped('Need to fix the Array Adapter to filter an array.');
        $filter = (new FilterBuilder())
            ->init()
            ->greaterThan('one', 2)
            ->build();
        $adapter = new ArrayAdapter();
        $adapter->setArray([1,2,3]);
        $adapter->apply($filter);
        $adaptedScalar = $adapter->getArray();
        $this->assertEquals([1,2,3], $adaptedScalar);

        $filter = (new FilterBuilder())
            ->init()
            ->greaterThan('one', 3)
            ->build();
        $adapter = new ArrayAdapter();
        $adapter->setArray([1,2,3]);
        $adapter->apply($filter);
        $adaptedScalar = $adapter->getArray();
        $this->assertNull($adaptedScalar);
    }


    /**
     * @throws CriterionException
     */
    public function testApplyWithGreaterThanOrEqualTo()
    {
        $this->markTestSkipped('Need to fix the Array Adapter to filter an array.');
        $filter = (new FilterBuilder())
            ->init()
            ->greaterThanOrEqualTo('one', 3)
            ->build();
        $adapter = new ArrayAdapter();
        $adapter->setArray([1,2,3]);
        $adapter->apply($filter);
        $adaptedScalar = $adapter->getArray();
        $this->assertEquals([1,2,3], $adaptedScalar);

        $filter = (new FilterBuilder())
            ->init()
            ->greaterThanOrEqualTo('one', 4)
            ->build();

        $adapter = new ArrayAdapter();
        $adapter->setArray([1,2,3]);
        $adapter->apply($filter);
        $adaptedScalar = $adapter->getArray();
        $this->assertNull($adaptedScalar);
    }
}
