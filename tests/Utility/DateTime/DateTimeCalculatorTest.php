<?php

namespace Nodez\Core\Tests\Utility\DateTime;

use Nodez\Core\Utility\DateTime\DateTimeCalculator;
use PHPUnit\Framework\TestCase;
use DateTimeImmutable;

class DateTimeCalculatorTest extends TestCase
{
    public function testInclusive(){
        $calculator = new DateTimeCalculator();

        $startDate = new DateTimeImmutable('2021-01-01 23:59:59');
        $endDate = new DateTimeImmutable('2021-01-01 00:00:00');
        $this->assertEquals(1, $calculator->calculateInclusiveDaysBetweenDates($startDate, $endDate));

        $startDate = new DateTimeImmutable('2021-01-01 23:59:59');
        $endDate = new DateTimeImmutable('2021-01-02 00:00:00');
        $this->assertEquals(2, $calculator->calculateInclusiveDaysBetweenDates($startDate, $endDate));

        $startDate = new DateTimeImmutable('2021-01-01 00:00:00');
        $endDate = new DateTimeImmutable('2021-01-02 23:59:59');
        $this->assertEquals(2, $calculator->calculateInclusiveDaysBetweenDates($startDate, $endDate));

        $startDate = new DateTimeImmutable('2021-01-01 00:00:00');
        $endDate = new DateTimeImmutable('2021-01-31 23:59:59');
        $this->assertEquals(31, $calculator->calculateInclusiveDaysBetweenDates($startDate, $endDate));

        $startDate = new DateTimeImmutable('2021-01-01 00:00:00');
        $endDate = new DateTimeImmutable('2021-12-31 23:59:59');
        $this->assertEquals(365, $calculator->calculateInclusiveDaysBetweenDates($startDate, $endDate));

        $startDate = new DateTimeImmutable('2020-01-01 00:00:00');
        $endDate = new DateTimeImmutable('2020-12-31 23:59:59');
        $this->assertEquals(366, $calculator->calculateInclusiveDaysBetweenDates($startDate, $endDate));

        $startDate = new DateTimeImmutable('2021-01-02 00:00:00');
        $endDate = new DateTimeImmutable('2021-01-01 00:00:00');
        $this->assertEquals(2, $calculator->calculateInclusiveDaysBetweenDates($startDate, $endDate));
    }
}
