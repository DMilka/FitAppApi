<?php

namespace App\Core\Exceptions\StandardExceptions;

class WrongValueException extends \LogicException
{
    const MESSAGE = 'exception:message.wrong_value_given';
    const CODE = 404;

}