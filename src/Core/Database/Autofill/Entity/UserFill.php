<?php

namespace App\Core\Database\Autofill\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

class UserFill
{
    /**
     * @Groups({"amount_type_write"})
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
     * @return UserFill
     */
    public function setUserId(int $userId): UserFill
    {
        $this->userId = $userId;
        return $this;
    }


}