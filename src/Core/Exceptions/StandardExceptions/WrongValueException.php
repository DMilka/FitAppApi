<?php

namespace App\Core\Exceptions\StandardExceptions;

use ApiPlatform\Core\Exception\ExceptionInterface;

class WrongValueException extends \LogicException implements ExceptionInterface
{
    const MESSAGE = 'exception:message.wrong_value_given';
    const CODE = 404;

}