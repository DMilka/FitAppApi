<?php

namespace App\Core\Database\HelperEntity;

use Doctrine\ORM\Mapping as ORM;

class UserExtension extends SoftDelete
{
    /**
     * @ORM\Column(type="integer", nullable=false, name="user_id")
     */
    protected int $userId;

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return UserExtension
     */
    public function setUserId(int $userId): UserExtension
    {
        $this->userId = $userId;
        return $this;
    }


}