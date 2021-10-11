<?php

namespace App\Core\Authentication\Helper;

class AuthenticationHelper
{
    // Auth properties
    public const LOGIN = 'username';
    public const PASSWORD = 'password';
    public const EMAIL = 'email';
    public const ID = 'userId';

    // Exceptions message

    public const MIN_LOGIN_LENGTH = 'min_login_length';
    public const MAX_LOGIN_LENGTH = 'max_login_length';
    public const MIN_PASSWORD_LENGTH = 'min_password_length';
    public const MAX_PASSWORD_LENGTH = 'max_password_length';

    public const MIN_LOGIN_LENGTH_VALUE = 5;
    public const MAX_LOGIN_LENGTH_VALUE = 10;
    public const MIN_PASSWORD_LENGTH_VALUE = 8;
    public const MAX_PASSWORD_LENGTH_VALUE = 15;


    public static function getAuthenticationLengthParameters(): array
    {
        return [
            self::MIN_LOGIN_LENGTH => 5,
            self::MAX_LOGIN_LENGTH => 10,
            self::MIN_PASSWORD_LENGTH => 8,
            self::MAX_PASSWORD_LENGTH => 15
        ];
    }
}