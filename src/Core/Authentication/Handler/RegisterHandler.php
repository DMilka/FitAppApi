<?php

namespace App\Core\Authentication\Handler;

use App\Core\Authentication\Helper\AuthenticationHelper;
use App\Core\HandlerAbstract;
use App\Entity\Users;

class RegisterHandler extends HandlerAbstract
{
    public function handleRegister(array $params): Users
    {
        $user = new Users();

        $user->setEmail($params[AuthenticationHelper::EMAIL]);
        $user->setPassword($params[AuthenticationHelper::PASSWORD]);
        $user->setUsername($params[AuthenticationHelper::LOGIN]);

        $this->persist($user);
        $this->flush();

        return $user;
    }
}