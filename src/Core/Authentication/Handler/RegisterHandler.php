<?php

namespace App\Core\Authentication\Handler;

use App\Core\Authentication\Helper\AuthenticationHelper;
use App\Core\HandlerAbstract;
use App\Entity\Users;

class RegisterHandler extends HandlerAbstract
{
    const REGISTER_COST = 12;
    const REGISTER_PASSWORD_ALGO = PASSWORD_BCRYPT;
    public function handleRegister(array $params): Users
    {
        $user = new Users();

        $user->setEmail($params[AuthenticationHelper::EMAIL]);
        $user->setPassword(password_hash($params[AuthenticationHelper::PASSWORD],self::REGISTER_PASSWORD_ALGO , ['cost' => self::REGISTER_COST]));
        $user->setUsername(htmlspecialchars($params[AuthenticationHelper::LOGIN]));

        $this->dbPersist($user);
        $this->dbFlush();

        return $user;
    }
}