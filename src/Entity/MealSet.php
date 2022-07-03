<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Core\Database\EntityTraits\EntityConnectorCreatorTrait;
use App\Core\Database\HelperEntity\UserExtension;
use App\Repository\MealSetRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;

/**
 * @ApiResource(
 *      collectionOperations={
 *          "get"={
 *              "security"="is_granted('ROLE_MEAL_SET_GET')",
 *              "normalization_context"={"groups"={"meal_set_read"}}
 *          },
 *          "post"={
 *              "security"="is_granted('ROLE_MEAL_SET_POST')",
 *              "normalization_context"={"groups"={"meal_set_read","entity_connector_creator_read"}},
 *              "denormalization_context"={"groups"={"meal_set_write","entity_connector_creator_write"}}
 *          },
 *     },
 *     itemOperations={
 *          "get"={
 *              "security"="is_granted('ROLE_MEAL_SET_GET')",
 *              "normalization_context"={"groups"={"meal_set_read"}}
 *          },
 *          "put"={
 *              "security"="is_granted('ROLE_MEAL_SET_PUT')",
 *              "normalization_context"={"groups"={"meal_set_read","entity_connector_creator_read"}},
 *              "denormalization_context"={"groups"={"meal_set_update","entity_connector_creator_update"}}
 *          },
 *          "delete"={
 *              "security"="is_granted('ROLE_MEAL_SET_DELETE')",
 *              "denormalization_context"={"groups"={"meal_set_delete"}}
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass=MealSetRepository::class)
 * @ApiFilter(SearchFilter::class, properties={"name": "ipartial", "description": "ipartial"})
 * @ApiFilter(OrderFilter::class, properties={"name", "description"})
 */
class MealSet extends UserExtension
{
    use EntityConnectorCreatorTrait;

    /**
     * @Groups({"meal_set_read"})
     * @ApiProperty(identifier=true)
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\SequenceGenerator(sequenceName="meal_set_id_seq")
     * @ORM\Column(type="integer", name="id")
     */
    private ?int $id = null;

    /**
     * @Groups({"meal_set_read", "meal_set_write","meal_set_update"})
     * @ORM\Column(type="string", length=255, name="name")
     */
    private string $name;

    /**
     * @Groups({"meal_set_read", "meal_set_write","meal_set_update"})
     * @ORM\Column(type="string", length=255, name="description")
     */
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
