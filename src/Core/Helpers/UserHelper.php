<?php

namespace App\Core\Helpers;

use App\Entity\Users;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserHelper
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }


    /** @return Users */
    public function getUser(): Users
    {
        /** @var Users $user */
        $user = $this->tokenStorage->getToken()->getUser();
        return $user;
    }


}