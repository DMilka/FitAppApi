<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Core\Database\HelperEntity\UserExtension;
use App\Repository\MealRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     attributes={"security"= "is_granted('ROLE_USER')"},
 *      collectionOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"meal_read"}}
 *          },
 *          "post"={
 *              "normalization_context"={"groups"={"meal_read"}},
 *              "denormalization_context"={"groups"={"meal_write"}}
 *          },
 *     },
 *     itemOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"meal_read"}}
 *          },
 *          "put"={
 *              "normalization_context"={"groups"={"meal_read"}},
 *              "denormalization_context"={"groups"={"meal_update"}}
 *          },
 *          "delete"={
 *              "denormalization_context"={"groups"={"meal_delete"}}
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass=MealRepository::class)
 */
class Meal extends UserExtension
{
    /**
     * @Groups({"meal_read"})
     * @ApiProperty(identifier=true)
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\SequenceGenerator(sequenceName="meal_id_seq")
     * @ORM\Column(type="integer", name="id")
     */
    private ?int $id = null;

    /**
     * @Groups({"meal_read", "meal_write","meal_update"})
     * @ORM\Column(type="string", length=255, name="name")
     */
    private string $name;

    /**
     * @Groups({"meal_read", "meal_write","meal_update"})
     * @ORM\Column(type="string", length=255, name="description")
     */
    private ?string $description = null;

    /**
     * @Groups({"meal_read", "meal_write","meal_update"})
     */
    private ?string $ingredientIds = null;


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

    /**
     * @return string|null
     */
    public function getIngredientIds(): ?string
    {
        return $this->ingredientIds;
    }

    /**
     * @param string|null $ingredientIds
     * @return Meal
     */
    public function setIngredientIds(?string $ingredientIds): Meal
    {
        $this->ingredientIds = $ingredientIds;
        return $this;
    }
}
