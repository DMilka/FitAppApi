<?php

namespace App\Core\Database\HelperEntity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class UserExtension extends SoftDelete
{
    #[Orm\Column(name:'user_id',type: 'integer')]
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