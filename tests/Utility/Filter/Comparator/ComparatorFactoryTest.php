<?php

namespace Unit;

use NoLoCo\Core\Utility\Filter\Comparator\BetweenComparator;
use NoLoCo\Core\Utility\Filter\Comparator\ComparatorFactory;
use NoLoCo\Core\Utility\Filter\Comparator\ContainsComparator;
use NoLoCo\Core\Utility\Filter\Comparator\EmptyTest;
use NoLoCo\Core\Utility\Filter\Comparator\EndsWithComparator;
use NoLoCo\Core\Utility\Filter\Comparator\EqualComparator;
use NoLoCo\Core\Utility\Filter\Comparator\GreaterThanComparator;
use NoLoCo\Core\Utility\Filter\Comparator\GreaterThanOrEqualToComparator;
use NoLoCo\Core\Utility\Filter\Comparator\InComparator;
use NoLoCo\Core\Utility\Filter\Comparator\LessThanComparator;
use NoLoCo\Core\Utility\Filter\Comparator\LessThanOrEqualToComparator;
use NoLoCo\Core\Utility\Filter\Comparator\NotEmptyTest;
use NoLoCo\Core\Utility\Filter\Comparator\NotEqualComparator;
use NoLoCo\Core\Utility\Filter\Comparator\NotInComparator;
use NoLoCo\Core\Utility\Filter\Comparator\StartsWithComparator;
use NoLoCo\Core\Utility\Filter\Criterion;
use PHPUnit\Framework\TestCase;

class ComparatorFactoryTest extends TestCase
{
    protected $factory;

    protected function setUp(): void
    {
        $this->factory = new ComparatorFactory();
    }

    public function testBuild()
    {
        $this->assertInstanceOf(EqualComparator::class, $this->factory->build(Criterion::EQ));
        $this->assertInstanceOf(NotEqualComparator::class, $this->factory->build(Criterion::NOT));
        $this->assertInstanceOf(GreaterThanComparator::class, $this->factory->build(Criterion::GT));
        $this->assertInstanceOf(GreaterThanOrEqualToComparator::class, $this->factory->build(Criterion::GTE));
        $this->assertInstanceOf(LessThanComparator::class, $this->factory->build(Criterion::LT));
        $this->assertInstanceOf(LessThanOrEqualToComparator::class, $this->factory->build(Criterion::LTE));
        $this->assertInstanceOf(InComparator::class, $this->factory->build(Criterion::IN));
        $this->assertInstanceOf(NotInComparator::class, $this->factory->build(Criterion::NIN));
        $this->assertInstanceOf(BetweenComparator::class, $this->factory->build(Criterion::BETWEEN));
        $this->assertInstanceOf(StartsWithComparator::class, $this->factory->build(Criterion::STARTS));
        $this->assertInstanceOf(EndsWithComparator::class, $this->factory->build(Criterion::ENDS));
        $this->assertInstanceOf(ContainsComparator::class, $this->factory->build(Criterion::CONTAINS));
        $this->assertInstanceOf(EmptyTest::class, $this->factory->build(Criterion::EMPTY));
        $this->assertInstanceOf(NotEmptyTest::class, $this->factory->build(Criterion::NOT_EMPTY));
    }
}
