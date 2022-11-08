<?php

namespace App\Core\Helpers;

class DateHelper
{
    static public function getActualDate(): \DateTime
    {
        return new \DateTime('now', new \DateTimeZone($_ENV['DATE_TIME_ZONE']));
    }

    static public function getActualDateString(?string $format = 'Y-m-d H:i:s'): string
    {
        $actualDate = self::getActualDate();
        return $actualDate->format($format);
    }
}