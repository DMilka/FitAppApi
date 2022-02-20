<?php

namespace App\Core\Authentication\Helper;

use App\Core\Exceptions\StandardExceptions\EmptyValueException;
use App\Core\Exceptions\StandardExceptions\RangeValueException;

class FormHelper
{
    public static function checkNullValue(?string $value): bool
    {
        if($value === null || strlen($value) === 0) {
            return false;
        }

        return true;
    }

    public static function checkNullValueWithException(?string $value): ?bool
    {
        $isValid = self::checkNullValue($value);

        if(!$isValid) {
            throw new EmptyValueException(EmptyValueException::MESSAGE);
        }

        return true;
    }

    public static function checkIfValueIsGreater(string $value,int $border): bool
    {
        return $value > $border;
    }

    public static function checkIfValueIsLower(string $value, int $border):bool
    {
        return $value < $border;
    }

    public static function checkIfValueIsGreaterOrEqual(string $value, int $border): bool
    {
        return $value >= $border;
    }

    public static function checkIfValueIsLowerOrEqual(string $value, int $border): bool
    {
        return $value <= $border;
    }

    public static function checkIfValueIsInRange(string $value, int $lowerBorder, int $greaterBorder, ?bool $lowerCanBeEqual = false, ?bool $greaterCanBeEqual = false): bool
    {
        $isValid = $lowerCanBeEqual ? self::checkIfValueIsLowerOrEqual($value, $lowerBorder) : self::checkIfValueIsLower($value, $lowerBorder);

        if(!$isValid) {
            return false;
        }

        $isValid = $greaterCanBeEqual ? self::checkIfValueIsGreaterOrEqual($value, $greaterBorder) : self::checkIfValueIsGreater($value, $greaterBorder);

        if(!$isValid) {
            return false;
        }

        return true;
    }

    public static function checkIfValueIsInRangeWithException(string $value, int $lowerBorder, int $greaterBorder, ?bool $lowerCanBeEqual = false, ?bool $greaterCanBeEqual = false): bool
    {
        $isValid = $lowerCanBeEqual ? self::checkIfValueIsLowerOrEqual($value, $lowerBorder) : self::checkIfValueIsLower($value, $lowerBorder);

        if(!$isValid) {
            throw new RangeValueException(RangeValueException::TO_LOW_MESSAGE);
        }

        $isValid = $greaterCanBeEqual ? self::checkIfValueIsGreaterOrEqual($value, $greaterBorder) : self::checkIfValueIsGreater($value, $greaterBorder);

        if(!$isValid) {
            throw new RangeValueException(RangeValueException::TO_HIGH_MESSAGE);
        }

        return true;
    }
}