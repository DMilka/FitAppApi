<?php

namespace App\Core\Exceptions\StandardExceptions;

use ApiPlatform\Core\Exception\ExceptionInterface;
use LogicException;

class EmptyValueException extends LogicException implements ExceptionInterface
{
    const MESSAGE = 'exception:message.empty_value';
    const CODE = 404;
}