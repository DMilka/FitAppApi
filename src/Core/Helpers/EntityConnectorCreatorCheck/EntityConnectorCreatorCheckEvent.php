<?php

namespace App\Core\Helpers\EntityConnectorCreatorCheck;

use Symfony\Contracts\EventDispatcher\Event;

class EntityConnectorCreatorCheckEvent extends Event
{
    private bool $isEntitySupportTrait = false;
    private object $parentEntity;
    private array $decodedElementsEntityList;

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
     * @return array
     */
    public function getDecodedElementsEntityList(): array
    {
        return $this->decodedElementsEntityList;
    }

    /**
     * @param array $decodedElementsEntityList
     * @return EntityConnectorCreatorCheckEvent
     */
    public function setDecodedElementsEntityList(array $decodedElementsEntityList): EntityConnectorCreatorCheckEvent
    {
        $this->decodedElementsEntityList = $decodedElementsEntityList;
        return $this;
    }
}