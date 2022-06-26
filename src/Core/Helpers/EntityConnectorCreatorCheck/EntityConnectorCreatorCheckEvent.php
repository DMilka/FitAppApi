<?php

namespace App\Core\Helpers\EntityConnectorCreatorCheck;

use Symfony\Contracts\EventDispatcher\Event;

class EntityConnectorCreatorCheckEvent extends Event
{
    private bool $isEntitySupportTrait = false;
    private object $parentEntity;
    private ?array $connectorClassElements = null;
    private array $connectorClassNameArr;
    private array $createdElements = [];


    public function __construct(object $parentEntity, array $connectorClassNameArr)
    {
        $this->parentEntity = $parentEntity;
        $this->connectorClassNameArr = $connectorClassNameArr;
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
     * @return array|null
     */
    public function getConnectorClassElements(): ?array
    {
        return $this->connectorClassElements;
    }

    /**
     * @param array|null $connectorClassElements
     * @return EntityConnectorCreatorCheckEvent
     */
    public function setConnectorClassElements(?array $connectorClassElements): EntityConnectorCreatorCheckEvent
    {
        $this->connectorClassElements = $connectorClassElements;
        return $this;
    }

    /**
     * @return array
     */
    public function getConnectorClassNameArr(): array
    {
        return $this->connectorClassNameArr;
    }

    /**
     * @param array $connectorClassNameArr
     * @return EntityConnectorCreatorCheckEvent
     */
    public function setConnectorClassNameArr(array $connectorClassNameArr): EntityConnectorCreatorCheckEvent
    {
        $this->connectorClassNameArr = $connectorClassNameArr;
        return $this;
    }

    /**
     * @return array
     */
    public function getCreatedElements(): array
    {
        return $this->createdElements;
    }

    /**
     * @param array $createdElements
     * @return EntityConnectorCreatorCheckEvent
     */
    public function setCreatedElements(array $createdElements): EntityConnectorCreatorCheckEvent
    {
        $this->createdElements = $createdElements;
        return $this;
    }
}