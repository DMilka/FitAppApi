<?php

namespace App\Core\Authentication\Event;

use App\Entity\Users;
use Symfony\Contracts\EventDispatcher\Event;

class RegisterEvent extends Event
{
    private ?array $params = null;

    private ?Users $users = null;

    private bool $shouldRegisterUser = false;

    /**
     * @return array|null
     */
    public function getParams(): ?array
    {
        return $this->params;
    }

    /**
     * @param array|null $params
     * @return RegisterEvent
     */
    public function setParams(?array $params): RegisterEvent
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @return bool
     */
    public function getShouldRegisterUser(): bool
    {
        return $this->shouldRegisterUser;
    }

    /**
     * @param bool $shouldRegisterUser
     * @return RegisterEvent
     */
    public function setShouldRegisterUser(bool $shouldRegisterUser): RegisterEvent
    {
        $this->shouldRegisterUser = $shouldRegisterUser;
        return $this;
    }

    /**
     * @return Users|null
     */
    public function getUsers(): ?Users
    {
        return $this->users;
    }

    /**
     * @param Users|null $users
     * @return RegisterEvent
     */
    public function setUsers(?Users $users): RegisterEvent
    {
        $this->users = $users;
        return $this;
    }
}