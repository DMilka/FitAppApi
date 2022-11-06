<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Core\Database\EntityTraits\EntityConnectorCreatorTrait;
use App\Core\Database\HelperEntity\UserExtension;
use Doctrine\ORM\Mapping as ORM;

///**
// * @ApiResource(
// *      collectionOperations={
// *          "get"={
// *              "security"="is_granted('ROLE_MEAL_SET_GET')",
// *              "normalization_context"={"groups"={"meal_set_read"}}
// *          },
// *          "post"={
// *              "security"="is_granted('ROLE_MEAL_SET_POST')",
// *              "normalization_context"={"groups"={"meal_set_read","entity_connector_creator_read"}},
// *              "denormalization_context"={"groups"={"meal_set_write","entity_connector_creator_write"}}
// *          },
// *     },
// *     itemOperations={
// *          "get"={
// *              "security"="is_granted('ROLE_MEAL_SET_GET')",
// *              "normalization_context"={"groups"={"meal_set_read"}}
// *          },
// *          "put"={
// *              "security"="is_granted('ROLE_MEAL_SET_PUT')",
// *              "normalization_context"={"groups"={"meal_set_read","entity_connector_creator_read"}},
// *              "denormalization_context"={"groups"={"meal_set_update","entity_connector_creator_update"}}
// *          },
// *          "delete"={
// *              "security"="is_granted('ROLE_MEAL_SET_DELETE')",
// *              "denormalization_context"={"groups"={"meal_set_delete"}}
// *          }
// *     }
// * )
// * @ORM\Entity(repositoryClass=MealSetRepository::class)
// * @ApiFilter(SearchFilter::class, properties={"name": "ipartial", "description": "ipartial"})
// * @ApiFilter(OrderFilter::class, properties={"name", "description"})
// */

#[ORM\Entity]
#[ApiResource]
class MealSet extends UserExtension
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
     * @return MealSet
     */
    public function setDescription(?string $description): MealSet
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMealIds(): ?string
    {
        return $this->mealIds;
    }

    /**
     * @param string|null $mealIds
     * @return MealSet
     */
    public function setMealIds(?string $mealIds): MealSet
    {
        $this->mealIds = $mealIds;
        return $this;
    }
}
