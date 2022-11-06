<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use App\Core\Database\EntityTraits\EntityConnectorCreatorTrait;
use App\Core\Database\HelperEntity\UserExtension;

///**
// * @ApiResource(
// *     attributes={"security"= "is_granted('ROLE_USER')"},
// *      collectionOperations={
// *          "get"={
// *              "security"="is_granted('ROLE_MEAL_GET')",
// *              "normalization_context"={"groups"={"meal_read"}}
// *          },
// *          "post"={
// *              "security"="is_granted('ROLE_MEAL_POST')",
// *              "normalization_context"={"groups"={"meal_read","entity_connector_creator_read"}},
// *              "denormalization_context"={"groups"={"meal_write","entity_connector_creator_write"}}
// *          },
// *     },
// *     itemOperations={
// *          "get"={
// *              "security"="is_granted('ROLE_MEAL_GET')",
// *              "normalization_context"={"groups"={"meal_read"}}
// *          },
// *          "put"={
// *              "security"="is_granted('ROLE_MEAL_PUT')",
// *              "normalization_context"={"groups"={"meal_read","entity_connector_creator_read"}},
// *              "denormalization_context"={"groups"={"meal_update","entity_connector_creator_update"}}
// *          },
// *          "delete"={
// *               "security"="is_granted('ROLE_MEAL_DELETE')",
// *              "denormalization_context"={"groups"={"meal_delete"}}
// *          }
// *     }
// * )
// * @ORM\Entity(repositoryClass=MealRepository::class)
// * @ApiFilter(SearchFilter::class, properties={"name": "ipartial", "description": "ipartial"})
// * @ApiFilter(OrderFilter::class, properties={"name", "description"})
// */

#[ORM\Entity]
#[ApiResource]
class Meal extends UserExtension
{
    use EntityConnectorCreatorTrait;

    #[Orm\Id, ORM\Column(name: 'id', type:'integer'), ORM\GeneratedValue]
    private ?int $id = null;

    #[Orm\Column(name:'name',type: 'string')]
    private string $name;

    #[Orm\Column(name:'description',type: 'string', nullable: true)]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return Meal
     */
    public function setDescription(?string $description): Meal
    {
        $this->description = $description;
        return $this;
    }
}
