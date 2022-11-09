<?php

namespace App\Core\Exceptions\StandardExceptions;

class UserNotFound extends \LogicException
{
    const MESSAGE = 'exception:message.user_not_found';

    const CODE = 404;

}