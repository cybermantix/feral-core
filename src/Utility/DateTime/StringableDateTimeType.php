<?php

namespace Nodez\Core\Utility\DateTime;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeType;

class StringableDateTimeType extends DateTimeType
{
    const NAME = 'stringabledatetime';

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * @inheritDoc
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $dateTime = parent::convertToPHPValue($value, $platform);

        if (! $dateTime) {
            return $dateTime;
        }

        return new StringableDateTime('@' . $dateTime->format('U'));
    }

}
