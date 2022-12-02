<?php

namespace NoLoCo\Core\Utility\DateTime;

use DateTime;
use DateTimeImmutable;

/**
 * Rule 1    Billing Period Number is the month the billing period start date is in. January is 1, June is 6, December is 12
 * Rule 2    The billing period start date is the provision date unless the provision date is greater than the last day of the month which then becomes the last day of the month.
 * Rule 3    Billing Period end day is one day before the provision date in the next month unless the provision date is greater than the last day of the month, then the billing end date is one day before the end of the month.
 * Rule 4    The number of days in the billing period equals the last day of the month of the billing period minus the billing start date plus the billing end date plus 1
 */
class ReferenceBasedDateTimeWindowCreator implements DateTimeWindowCreatorInterface
{

    /**
     * @inheritDoc
     */
    public function createWindowWithWindows(DateTimeWindow $dateTimeWindow1, DateTimeWindow $dateTimeWindow2): DateTimeWindow
    {
        if ($dateTimeWindow1->getStartDateTime() > $dateTimeWindow2->getStartDateTime()) {
            $startDateTime = $dateTimeWindow1->getStartDateTime();
        } else {
            $startDateTime = $dateTimeWindow2->getStartDateTime();
        }
        if ($dateTimeWindow1->getEndDateTime() < $dateTimeWindow2->getEndDateTime()) {
            $endDateTime = $dateTimeWindow1->getEndDateTime();
        } else {
            $endDateTime = $dateTimeWindow2->getEndDateTime();
        }
        return (new DateTimeWindow())
            ->setStartDateTime($startDateTime)
            ->setEndDateTime($endDateTime);
    }

    /**
     * @inheritDoc
     */
    public function create(DateTimeImmutable $referenceDate, $month, $year): DateTimeWindow
    {
        $referenceDayOfMonth = $this->getDayOfMonth($referenceDate);

        // START DATE
        $startDate = new DateTime(sprintf('%u-%u-01', $year, $month));
        $lastDayOfMonth = $this->lastDayOfAMonth(DateTimeImmutable::createFromMutable($startDate));
        if (1 < $referenceDayOfMonth) {
            if ($referenceDayOfMonth > $lastDayOfMonth) {
                $startDate->setDate($year, $month, $lastDayOfMonth);
            } else {
                $startDate->setDate($year, $month, $referenceDayOfMonth);
            }
        }

        if (1 == $referenceDayOfMonth) {
            $endDate = new DateTime(sprintf('%u-%u-%u', $year, $month, $lastDayOfMonth));
        } else {
            // END DATE
            if (12 == $month) {
                $endYear = $year + 1;
                $endMonth = 1;
            } else {
                $endYear = $year;
                $endMonth = $month + 1;
            }
            $endDate = new DateTime(sprintf('%u-%u-01', $endYear, $endMonth));
            $lastDayOfEndMonth = $this->lastDayOfAMonth(DateTimeImmutable::createFromMutable($endDate));
            if ($referenceDayOfMonth > $lastDayOfEndMonth) {
                $endDate->setDate($endYear, $endMonth, $lastDayOfEndMonth - 1);
            } else {
                $endDate->setDate($endYear, $endMonth, $referenceDayOfMonth - 1);
            }
        }

        return (new DateTimeWindow())
            ->setStartDateTime(DateTimeImmutable::createFromMutable($startDate))
            ->setEndDateTime(DateTimeImmutable::createFromMutable($endDate));
    }

    protected function getDayOfMonth(DateTimeImmutable $referenceDate): int
    {
        return (int)$referenceDate->format('j');
    }

    protected function getMonthNumber(DateTimeImmutable $referenceDate): int
    {
        return (int)$referenceDate->format('n');
    }

    protected function lastDayOfAMonth(DateTimeImmutable $referenceDate): int
    {
        return (int)$referenceDate->format('t');
    }
}
