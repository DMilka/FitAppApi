<?php

namespace App\Core\Database\EntityTraits;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     attributes={"security"= "is_granted('ROLE_ENTITY_CONNECTOR_CREATOR')"},
 *      collectionOperations={
 *          "post"={
 *              "security"="is_granted('ROLE_ENTITY_CONNECTOR_CREATOR_POST')",
 *              "normalization_context"={"groups"={"entity_connector_creator_read"}},
 *              "denormalization_context"={"groups"={"entity_connector_creator_write"}}
 *          }
 *     },
 *     itemOperations={
 *          "put"={
 *              "security"="is_granted('ROLE_ENTITY_CONNECTOR_CREATOR_PUT')",
 *              "normalization_context"={"groups"={"entity_connector_creator_read"}},
 *              "denormalization_context"={"groups"={"entity_connector_creator_update"}}
 *          }
 *     }
 * )
 */
trait EntityConnectorCreatorTrait
{
    /**
     * @Groups({"entity_connector_creator_read","entity_connector_creator_write","entity_connector_creator_update"})
     */
    private ?string $connectorItems;

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