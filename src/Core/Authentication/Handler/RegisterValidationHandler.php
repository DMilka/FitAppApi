<?php

namespace App\Core\Authentication\Handler;

use App\Core\Authentication\Helper\AuthenticationHelper;
use App\Core\Translations\AuthenticationTranslations;
use App\Core\HandlerAbstract;
use Cassandra\Exception\AuthenticationException;
use Doctrine\DBAL\Exception\DatabaseObjectExistsException;
use InvalidArgumentException;


class RegisterValidationHandler extends HandlerAbstract
{
    public function validateUser(array $params): void
    {
        $validationParams = AuthenticationHelper::getAuthenticationLengthParameters();

        if(!array_key_exists(AuthenticationHelper::LOGIN, $params)) {
            throw new InvalidArgumentException(AuthenticationTranslations::LOGIN_LENGTH_EXCEPTION_MESSAGE);
        }

        if(strlen($params[AuthenticationHelper::LOGIN]) < $validationParams[AuthenticationHelper::MIN_LOGIN_LENGTH] || strlen($params[AuthenticationHelper::LOGIN]) > $validationParams[AuthenticationHelper::MAX_LOGIN_LENGTH] ) {
            throw new InvalidArgumentException(AuthenticationTranslations::LOGIN_LENGTH_EXCEPTION_MESSAGE);
        }

        if(!array_key_exists(AuthenticationHelper::PASSWORD, $params)) {
            throw new InvalidArgumentException(AuthenticationTranslations::PASSWORD_LENGTH_EXCEPTION_MESSAGE);
        }

        if(strlen($params[AuthenticationHelper::PASSWORD]) < $validationParams[AuthenticationHelper::MIN_PASSWORD_LENGTH] || strlen($params[AuthenticationHelper::PASSWORD]) > $validationParams[AuthenticationHelper::MAX_PASSWORD_LENGTH] ) {
            throw new InvalidArgumentException(AuthenticationTranslations::PASSWORD_LENGTH_EXCEPTION_MESSAGE);
        }

        if(!array_key_exists(AuthenticationHelper::EMAIL, $params)) {
            throw new InvalidArgumentException(AuthenticationTranslations::EMAIL_INCORRECT_EXCEPTION_MESSAGE);
        }

        if(!filter_var($params[AuthenticationHelper::EMAIL], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(AuthenticationTranslations::EMAIL_INCORRECT_EXCEPTION_MESSAGE);
        }
    }

    public function checkUserExist(array $params): void
    {
        $userName = $params[AuthenticationHelper::LOGIN];
        $email = $params[AuthenticationHelper::EMAIL];

        $user = $this->getUserRepository()->findOneOrNullByUserName($userName);

        if($user) {
            throw new \Exception(AuthenticationTranslations::LOGIN_EXIST_EXCEPTION_MESSAGE);
        }

        $user = $this->getUserRepository()->findOneOrNullByEmail($email);

        if($user) {
            throw new \Exception(AuthenticationTranslations::EMAIL_EXIST_EXCEPTION_MESSAGE);
        }
    }
}