<?php

namespace App\Core\Authentication\Handler;

use App\Core\Authentication\Helper\AuthenticationHelper;
use App\Core\HandlerAbstract;
use http\Exception\InvalidArgumentException;

class RegisterValidationHandler extends HandlerAbstract
{
    public function validateUser(array $params): void
    {
        if(!array_key_exists(AuthenticationHelper::LOGIN, $params)) {
            throw new InvalidArgumentException(AuthenticationHelper::LOGIN_LENGTH_EXCEPTION_MESSAGE);
        }

        if(!array_key_exists(AuthenticationHelper::PASSWORD, $params)) {
            throw new InvalidArgumentException(AuthenticationHelper::PASSWORD_LENGTH_EXCEPTION_MESSAGE);
        }

        if(!array_key_exists(AuthenticationHelper::EMAIL, $params)) {
            throw new InvalidArgumentException(AuthenticationHelper::EMAIL_INCORRECT_EXCEPTION_MESSAGE);
        }
    }
}