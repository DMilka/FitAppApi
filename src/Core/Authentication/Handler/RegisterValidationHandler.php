<?php

namespace App\Core\Authentication\Handler;

use App\Core\Authentication\Helper\AuthenticationHelper;
use App\Core\HandlerAbstract;
use InvalidArgumentException;


class RegisterValidationHandler extends HandlerAbstract
{
    public function validateUser(array $params): void
    {
        $validationParams = AuthenticationHelper::getAuthenticationLengthParameters();

        if(!array_key_exists(AuthenticationHelper::LOGIN, $params)) {
            throw new InvalidArgumentException(AuthenticationHelper::LOGIN_LENGTH_EXCEPTION_MESSAGE);
        }

        if(strlen($params[AuthenticationHelper::LOGIN]) < $validationParams[AuthenticationHelper::MIN_LOGIN_LENGTH] || strlen($params[AuthenticationHelper::LOGIN]) > $validationParams[AuthenticationHelper::MAX_LOGIN_LENGTH] ) {
            throw new InvalidArgumentException(AuthenticationHelper::LOGIN_LENGTH_EXCEPTION_MESSAGE);
        }

        if(!array_key_exists(AuthenticationHelper::PASSWORD, $params)) {
            throw new InvalidArgumentException(AuthenticationHelper::PASSWORD_LENGTH_EXCEPTION_MESSAGE);
        }

        if(strlen($params[AuthenticationHelper::PASSWORD]) < $validationParams[AuthenticationHelper::MIN_PASSWORD_LENGTH] || strlen($params[AuthenticationHelper::PASSWORD]) > $validationParams[AuthenticationHelper::MAX_PASSWORD_LENGTH] ) {
            throw new InvalidArgumentException(AuthenticationHelper::PASSWORD_LENGTH_EXCEPTION_MESSAGE);
        }

        if(!array_key_exists(AuthenticationHelper::EMAIL, $params)) {
            throw new InvalidArgumentException(AuthenticationHelper::EMAIL_INCORRECT_EXCEPTION_MESSAGE);
        }

        if(!filter_var($params[AuthenticationHelper::EMAIL], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(AuthenticationHelper::EMAIL_INCORRECT_EXCEPTION_MESSAGE);
        }
    }
}