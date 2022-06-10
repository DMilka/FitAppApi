<?php

namespace App\Core\Helpers\EntityConnectorCreatorCheck;

use Symfony\Contracts\EventDispatcher\Event;

class EntityConnectorCreatorCheckEvent extends Event
{
    private bool $isEntitySupportTrait = false;
    private object $parentEntity;
    private ?array $childEntityElements = null;
    private ?string $childEntityName = null;

    public function __construct(object $parentEntity)
    {
        $this->parentEntity = $parentEntity;
    }

    /**
     * @return object
     */
    public function getParentEntity(): object
    {
        return $this->parentEntity;
    }

    /**
     * @param object $parentEntity
     * @return EntityConnectorCreatorCheckEvent
     */
    public function setParentEntity(object $parentEntity): EntityConnectorCreatorCheckEvent
    {
        $this->parentEntity = $parentEntity;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEntitySupportTrait(): bool
    {
        return $this->isEntitySupportTrait;
    }

    /**
     * @param bool $isEntitySupportTrait
     * @return EntityConnectorCreatorCheckEvent
     */
    public function setIsEntitySupportTrait(bool $isEntitySupportTrait): EntityConnectorCreatorCheckEvent
    {
        $this->isEntitySupportTrait = $isEntitySupportTrait;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getChildEntityElements(): ?array
    {
        return $this->childEntityElements;
    }

    /**
     * @param array|null $childEntityElements
     * @return EntityConnectorCreatorCheckEvent
     */
    public function setChildEntityElements(?array $childEntityElements): EntityConnectorCreatorCheckEvent
    {
        $this->childEntityElements = $childEntityElements;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getChildEntityName(): ?string
    {
        return $this->childEntityName;
    }

    /**
     * @param string|null $childEntityName
     * @return EntityConnectorCreatorCheckEvent
     */
    public function setChildEntityName(?string $childEntityName): EntityConnectorCreatorCheckEvent
    {
        $this->childEntityName = $childEntityName;
        return $this;
    }
}