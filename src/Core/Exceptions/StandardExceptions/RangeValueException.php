<?php

namespace App\Core\Exceptions\StandardExceptions;

class RangeValueException extends \LogicException
{
    const TO_LOW_MESSAGE = 'exception:message.value_is_to_lower_than_border';
    const TO_HIGH_MESSAGE = 'exception:message.value_is_greater_than_border';
    const CODE = 404;

}