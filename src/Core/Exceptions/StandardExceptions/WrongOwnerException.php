<?php

namespace App\Core\Exceptions\StandardExceptions;

use ApiPlatform\Core\Exception\ExceptionInterface;

class WrongOwnerException extends \LogicException implements ExceptionInterface
{
    const MESSAGE = 'exception:message.internal_server_error';
    const CODE = 404;

}