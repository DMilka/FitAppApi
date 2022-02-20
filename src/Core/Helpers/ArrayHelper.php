<?php

namespace App\Core\Helpers;

class ArrayHelper
{
    public static function getNewElementsFromArrays(array $oldArray, array $newArray): array
    {
        return array_diff($newArray, $oldArray);
    }

    public static function getOldElementsFromArrays(array $oldArray, array $newArray): array
    {
        return array_diff($oldArray, $newArray);
    }
}