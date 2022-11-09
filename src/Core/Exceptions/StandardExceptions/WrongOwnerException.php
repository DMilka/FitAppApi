<?php

namespace App\Core\Exceptions\StandardExceptions;

class WrongOwnerException extends \LogicException
{
    const MESSAGE = 'exception:message.internal_server_error';
    const CODE = 403;

}