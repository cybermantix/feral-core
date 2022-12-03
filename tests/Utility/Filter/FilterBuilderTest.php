<?php

namespace Nodez\Core\Tests\Utility\Filter;

use Nodez\Core\Utility\Filter\Criterion;
use Nodez\Core\Utility\Filter\Exception\CriterionException;
use Nodez\Core\Utility\Filter\Exception\FilterLimitException;
use Nodez\Core\Utility\Filter\FilterBuilder;
use Nodez\Core\Utility\Filter\Order;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class FilterBuilderTest extends TestCase
{
    protected FilterBuilder $builder;

    protected function setUp(): void
    {
        $this->builder = new FilterBuilder();
    }

    public function testWithPage()
    {
        $filter = $this->builder
            ->init()
            ->withPage(2)
            ->build();
        $this->assertEquals(2, $filter->getPage());
    }

    /**
     * @throws FilterLimitException
     */
    public function testWithLimit()
    {
        $filter = $this->builder
            ->init()
            ->withLimit(10)
            ->build();
        $this->assertEquals(10, $filter->getLimit());
    }

    /**
     * @throws FilterLimitException
     */
    public function testAddOrder()
    {
        $filter = $this->builder
            ->init()
            ->addOrder('test', 'ASC')
            ->build();
        $data = $filter->getOrders();
        $this->assertCount(1, $data);
        $datum = $data['test'];
        $this->assertEquals('test', $datum->getKey());
        $this->assertEquals(Order::ASC, $datum->getDirection());
    }

    /**
     * @throws CriterionException
     */
    public function testGreaterThanOrEqualTo()
    {
        $filter = $this->builder
            ->init()
            ->greaterThanOrEqualTo('test', '1.0')
            ->build();
        $data = $filter->getCriteria();
        $this->assertCount(1, $data);
        $datum = array_pop($data['test']);
        $this->assertEquals('test', $datum->getKey());
        $this->assertEquals(Criterion::GTE, $datum->getOperator());
        $this->assertEquals('1.0', $datum->getValue());
    }

    /**
     * @throws CriterionException
     */
    public function testBetween()
    {
        $filter = $this->builder
            ->init()
            ->between('test', '0.0|1.0')
            ->build();
        $data = $filter->getCriteria();
        $this->assertCount(1, $data);
        /** @var Criterion $datum */
        $datum = array_pop($data['test']);
        $this->assertEquals('test', $datum->getKey());
        $this->assertEquals(Criterion::BETWEEN, $datum->getOperator());
        $this->assertIsArray($datum->getValueArray());
        $values = $datum->getValueArray();
        $this->assertEquals('0.0', $values[0]);
        $this->assertEquals(1.0, $values[1]);
    }

    /**
     * @throws CriterionException
     */
    public function testBetweenFloatRange()
    {
        $filter = $this->builder
            ->init()
            ->betweenFloatRange('test', 0.0, 1.0)
            ->build();
        $data = $filter->getCriteria();
        $this->assertCount(1, $data);
        $datum = array_pop($data['test']);
        $this->assertEquals('test', $datum->getKey());
        $this->assertEquals(Criterion::BETWEEN, $datum->getOperator());
        $values = $datum->getValueArray();
        $this->assertEquals(0.0, $values[0]);
        $this->assertEquals(1.0, $values[1]);
    }

    /**
     * @throws CriterionException
     */
    public function testBetweenIntRange()
    {
        $filter = $this->builder
            ->init()
            ->betweenFloatRange('test', 0, 1)
            ->build();
        $data = $filter->getCriteria();
        $this->assertCount(1, $data);
        $datum = array_pop($data['test']);
        $this->assertEquals('test', $datum->getKey());
        $this->assertEquals(Criterion::BETWEEN, $datum->getOperator());
        $values = $datum->getValueArray();
        $this->assertEquals(0, $values[0]);
        $this->assertEquals(1, $values[1]);
    }

    /**
     * @throws CriterionException
     */
    public function testBetweenDateTimeRange()
    {
        $filter = $this->builder
            ->init()
            ->betweenDateTimeRange(
                'test',
                new DateTimeImmutable('2020-01-01 03:01:55'),
                new DateTimeImmutable('2020-01-31 15:21:35')
            )
            ->build();
        $data = $filter->getCriteria();
        $this->assertCount(1, $data);
        $datum = array_pop($data['test']);
        $this->assertEquals('test', $datum->getKey());
        $this->assertEquals(Criterion::BETWEEN, $datum->getOperator());
        $values = $datum->getValueArray();
        $this->assertEquals('2020-01-01 03:01:55', $values[0]);
        $this->assertEquals('2020-01-31 15:21:35', $values[1]);
    }

    /**
     * @throws CriterionException
     */
    public function testBetweenStringRange()
    {
        $filter = $this->builder
            ->init()
            ->betweenStringRange(
                'test',
                'one',
                'two'
            )
            ->build();
        $data = $filter->getCriteria();
        $this->assertCount(1, $data);
        $datum = array_pop($data['test']);
        $this->assertEquals('test', $datum->getKey());
        $this->assertEquals(Criterion::BETWEEN, $datum->getOperator());
        $values = $datum->getValueArray();
        $this->assertEquals('one', $values[0]);
        $this->assertEquals('two', $values[1]);
    }

    /**
     * @throws CriterionException
     */
    public function testLessThan()
    {
        $filter = $this->builder
            ->init()
            ->lessThan('test', '1.0')
            ->build();
        $data = $filter->getCriteria();
        $datum = array_pop($data['test']);
        $this->assertCount(1, $data);
        $this->assertEquals(Criterion::LT, $datum->getOperator());
        $this->assertEquals('1.0', $datum->getValue());
    }

    /**
     * @throws CriterionException
     */
    public function testLessThanOrEqualTo()
    {
        $filter = $this->builder
            ->init()
            ->lessThanOrEqualTo('test', '1.0')
            ->build();
        $data = $filter->getCriteria();
        $datum = array_pop($data['test']);
        $this->assertCount(1, $data);
        $this->assertEquals(Criterion::LTE, $datum->getOperator());
        $this->assertEquals('1.0', $datum->getValue());
    }

    /**
     * @throws CriterionException
     */
    public function testGreaterThan()
    {
        $filter = $this->builder
            ->init()
            ->greaterThan('test', '1.0')
            ->build();
        $data = $filter->getCriteria();
        $datum = array_pop($data['test']);
        $this->assertCount(1, $data);
        $this->assertEquals(Criterion::GT, $datum->getOperator());
        $this->assertEquals('1.0', $datum->getValue());
    }

    /**
     * @throws CriterionException
     */
    public function testEqual()
    {
        $filter = $this->builder
            ->init()
            ->equal('test', '1.0')
            ->build();
        $data = $filter->getCriteria();
        $datum = array_pop($data['test']);
        $this->assertCount(1, $data);
        $this->assertEquals(Criterion::EQ, $datum->getOperator());
        $this->assertEquals('1.0', $datum->getValue());
    }

    /**
     * @throws CriterionException
     */
    public function testNotEqual()
    {
        $filter = $this->builder
            ->init()
            ->notEqual('test', '1.0')
            ->build();
        $data = $filter->getCriteria();
        $datum = array_pop($data['test']);
        $this->assertCount(1, $data);
        $this->assertEquals(Criterion::NOT, $datum->getOperator());
        $this->assertEquals('1.0', $datum->getValue());
    }
}
