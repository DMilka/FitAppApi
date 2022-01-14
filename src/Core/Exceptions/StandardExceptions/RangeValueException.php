<?php

namespace App\Core\Exceptions\StandardExceptions;

use ApiPlatform\Core\Exception\ExceptionInterface;

class RangeValueException extends \LogicException implements ExceptionInterface
{
    const TO_LOW_MESSAGE = 'exception:message.value_is_to_lower_than_border';
    const TO_HIGH_MESSAGE = 'exception:message.value_is_greater_than_border';
    const CODE = 404;

}