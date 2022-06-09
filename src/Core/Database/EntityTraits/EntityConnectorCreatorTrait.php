<?php

namespace App\Core\Database\EntityTraits;

trait EntityConnectorCreatorTrait
{
    private ?string $entityName;
    private ?string $connectorItems;

    /**
     * @return string|null
     */
    public function getEntityName(): ?string
    {
        return $this->entityName;
    }

    /**
     * @param string|null $entityName
     */
    public function setEntityName(?string $entityName): void
    {
        $this->entityName = $entityName;
    }

    /**
     * @return string|null
     */
    public function getConnectorItems(): ?string
    {
        return $this->connectorItems;
    }

    /**
     * @param string|null $connectorItems
     */
    public function setConnectorItems(?string $connectorItems): void
    {
        $this->connectorItems = $connectorItems;
    }


}