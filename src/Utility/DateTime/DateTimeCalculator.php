<?php

namespace Feral\Core\Utility\DateTime;

use DateTime;
use DateTimeImmutable;

class DateTimeCalculator
{
    /**
     * The absolute value of days between two dates. Include the start and end date.
     * January 1st to January 31st is 31 days.
     *
     * @param  DateTimeImmutable $startDateTime
     * @param  DateTimeImmutable $endDateTime
     * @return int
     */
    public function calculateInclusiveDaysBetweenDates(DateTimeImmutable $startDateTime, DateTimeImmutable $endDateTime): int
    {
        $startDateTime = DateTime::createFromImmutable($startDateTime);
        $endDateTime = DateTime::createFromImmutable($endDateTime);
        $startDateTime->setTime(0, 0, 0);
        $endDateTime->setTime(0, 0, 0);
        return 1 + (int)$endDateTime->diff($startDateTime)->format('%a');
    }

    public function calculateExclusiveDaysBetweenDates(DateTimeImmutable $startDateTime, DateTimeImmutable $endDateTime): int
    {
        $startDateTime = DateTime::createFromImmutable($startDateTime);
        $endDateTime = DateTime::createFromImmutable($endDateTime);
        $startDateTime->setTime(0, 0, 0);
        $endDateTime->setTime(0, 0, 0);
        return 1 - (int)$endDateTime->diff($startDateTime)->format('%a');
    }
}
