<?php


namespace Nodez\Core\Utility\DateTime;


use DateTime;
use DateTimeImmutable;

class DateTimeWindow
{
    /**
     * @var DateTimeImmutable
     */
    protected DateTimeImmutable $startDateTime;

    /**
     * @var DateTimeImmutable
     */
    protected DateTimeImmutable $endDateTime;

    /**
     * @return DateTimeImmutable
     */
    public function getStartDateTime(): DateTimeImmutable
    {
        return $this->startDateTime;
    }

    /**
     * @param  DateTimeImmutable $startDateTime
     * @return DateTimeWindow
     */
    public function setStartDateTime(DateTimeImmutable $startDateTime): DateTimeWindow
    {
        $this->startDateTime = $startDateTime;
        return $this;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getEndDateTime(): DateTimeImmutable
    {
        return $this->endDateTime;
    }

    /**
     * @param  DateTimeImmutable $endDateTime
     * @return DateTimeWindow
     */
    public function setEndDateTime(DateTimeImmutable $endDateTime): DateTimeWindow
    {
        $this->endDateTime = $endDateTime;
        return $this;
    }
}
