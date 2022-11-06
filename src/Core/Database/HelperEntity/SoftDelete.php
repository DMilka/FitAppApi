<?php

namespace App\Core\Database\HelperEntity;

use App\Repository\UsersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class SoftDelete
{

    #[Orm\Column(name:'deleted',type: 'boolean')]
    protected bool $deleted = false;

    #[Orm\Column(name:'deleted_at',type: 'datetime', nullable: true)]
    protected ?\DateTime $deletedAt = null;

    /**
     * @return bool
     */
    public function getDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * @param bool $deleted
     * @return SoftDelete
     */
    public function setDeleted(bool $deleted): SoftDelete
    {
        $this->deleted = $deleted;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDeletedAt(): ?\DateTime
    {
        return $this->deletedAt;
    }

    /**
     * @param \DateTime|null $deletedAt
     * @return SoftDelete
     */
    public function setDeletedAt(?\DateTime $deletedAt): SoftDelete
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }


}