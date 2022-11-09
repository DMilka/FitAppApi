<?php

namespace App\Core\Exceptions\StandardExceptions;

use LogicException;

class EmptyValueException extends LogicException
{
    const MESSAGE = 'exception:message.empty_value';
    const CODE = 500;
}