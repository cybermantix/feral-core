<?php

namespace NoLoCo\Core\Tests\Utility\Set;

use NoLoCo\Core\Utility\Set\Exception\InvalidSetException;
use NoLoCo\Core\Utility\Set\SetComparator;
use PHPUnit\Framework\TestCase;

class SetComparatorTest extends TestCase
{

    public function testArrayProcess()
    {
        $left = [
            ['id' => 1, 'name' => 'test 1'],
            ['id' => 3, 'name' => 'test 3'],
            ['id' => 5, 'name' => 'test 5'],
        ];
        $right = [
            ['id' => 1, 'name' => 'test 1'],
            ['id' => 2, 'name' => 'test 2'],
            ['id' => 3, 'name' => 'test 3'],
        ];
        $comparator = (new SetComparator())
            ->setLeft($left)
            ->setRight($right)
            ->process('id');

        $matching = $comparator->getMatchingOnly();
        $leftOnly = $comparator->getLeftOnly();
        $rightOnly = $comparator->getRightOnly();

        $this->assertCount(2, $matching);
        $this->assertCount(1, $leftOnly);
        $this->assertCount(1, $rightOnly);
    }

    public function testObjectProcess()
    {
        $left = [
            (new SimpleClass())->setSequence('abc')->setIndex(1),
            (new SimpleClass())->setSequence('def')->setIndex(2),
            (new SimpleClass())->setSequence('xyz')->setIndex(3),
        ];
        $right = [
            (new SimpleClass())->setSequence('abc')->setIndex(1),
            (new SimpleClass())->setSequence('ghi')->setIndex(2),
            (new SimpleClass())->setSequence('xyz')->setIndex(3),
        ];
        $comparator = (new SetComparator())
            ->setLeft($left)
            ->setRight($right)
            ->process('sequence');

        $matching = $comparator->getMatchingOnly();
        $leftOnly = $comparator->getLeftOnly();
        $rightOnly = $comparator->getRightOnly();

        $this->assertCount(2, $matching);
        $this->assertCount(1, $leftOnly);
        $this->assertCount(1, $rightOnly);
    }


    public function testDifferentKeyPath()
    {
        $left = [
            ['id' => 1, 'name' => 'test 1'],
            ['id' => 3, 'name' => 'test 3'],
            ['id' => 5, 'name' => 'test 5'],
        ];
        $right = [
            ['xid' => 1, 'name' => 'test 1'],
            ['xid' => 2, 'name' => 'test 2'],
            ['xid' => 3, 'name' => 'test 3'],
        ];
        $comparator = (new SetComparator())
            ->setLeft($left)
            ->setRight($right)
            ->process('id', 'xid');

        $matching = $comparator->getMatchingOnly();
        $leftOnly = $comparator->getLeftOnly();
        $rightOnly = $comparator->getRightOnly();

        $this->assertCount(2, $matching);
        $this->assertCount(1, $leftOnly);
        $this->assertCount(1, $rightOnly);
    }

    public function testEmpty()
    {
        $this->expectException(InvalidSetException::class);
        $comparator = (new SetComparator())
            ->setLeft(null)
            ->setRight([])
            ->process('sequence');
    }
}

class SimpleClass
{
    protected string $sequence;

    protected int $index;

    /**
     * @return string
     */
    public function getSequence(): string
    {
        return $this->sequence;
    }

    /**
     * @param string $sequence
     * @return SimpleClass
     */
    public function setSequence(string $sequence): SimpleClass
    {
        $this->sequence = $sequence;
        return $this;
    }

    /**
     * @return int
     */
    public function getIndex(): int
    {
        return $this->index;
    }

    /**
     * @param int $index
     * @return SimpleClass
     */
    public function setIndex(int $index): SimpleClass
    {
        $this->index = $index;
        return $this;
    }
}
