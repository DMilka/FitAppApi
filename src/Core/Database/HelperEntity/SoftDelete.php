<?php

namespace App\Core\Database\HelperEntity;

use Doctrine\ORM\Mapping as ORM;

class SoftDelete
{
    /**
     * @ORM\Column(type="boolean", nullable=false, name="deleted")
     */
    protected bool $deleted = false;

    /**
     * @ORM\Column(type="datetime", nullable=true, name="deleted_at")
     */
    protected ?\DateTime $deletedAt = null;

    /**
     * @return bool
     */
    public function isDeleted(): bool
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