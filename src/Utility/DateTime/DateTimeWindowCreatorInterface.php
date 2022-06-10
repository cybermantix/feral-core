<?php

namespace NoLoCo\Core\Utility\DateTime;

use DateTimeImmutable;

interface DateTimeWindowCreatorInterface
{
    /**
     * Create a window of time that is common to both windows.
     * @param DateTimeWindow $dateTimeWindow1
     * @param DateTimeWindow $dateTimeWindow2
     * @return DateTimeWindow
     */
    public function createWindowWithWindows(DateTimeWindow $dateTimeWindow1, DateTimeWindow $dateTimeWindow2): DateTimeWindow;

    /**
     * Create a window of time based on a reference date, month, and year.
     * @param DateTimeImmutable $referenceDate
     * @param $month
     * @param $year
     * @return DateTimeWindow
     */
    public function create(DateTimeImmutable $referenceDate, $month, $year):DateTimeWindow;
}
