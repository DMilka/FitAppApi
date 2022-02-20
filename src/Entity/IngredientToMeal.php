<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Core\Database\HelperEntity\SoftDelete;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\IngredientToMealRepository;

/**
 * @ApiResource(
 *      collectionOperations={
 *          "get"={
 *              "security"="is_granted('ROLE_INGREDIENT_TO_MEAL_GET')",
 *              "normalization_context"={"groups"={"ingredient_to_meal_read"}}
 *          },
 *          "post"={
 *              "security"="is_granted('ROLE_INGREDIENT_TO_MEAL_POST')",
 *              "normalization_context"={"groups"={"ingredient_to_meal_read"}},
 *              "denormalization_context"={"groups"={"ingredient_to_meal_write"}}
 *          },
 *     },
 *     itemOperations={
 *          "get"={
 *              "security"="is_granted('ROLE_INGREDIENT_TO_MEAL_GET')",
 *              "normalization_context"={"groups"={"ingredient_to_meal_read"}}
 *          },
 *          "put"={
 *              "security"="is_granted('ROLE_INGREDIENT_TO_MEAL_PUT')",
 *              "normalization_context"={"groups"={"ingredient_to_meal_read"}},
 *              "denormalization_context"={"groups"={"ingredient_to_meal_update"}}
 *          },
 *          "delete"={
 *              "security"="is_granted('ROLE_INGREDIENT_TO_MEAL_DELETE')",
 *              "denormalization_context"={"groups"={"meal_set_delete"}}
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass=IngredientToMealRepository::class)
 */
class IngredientToMeal extends SoftDelete
{
    /**
     * @Groups({"ingredient_to_meal_read"})
     * @ApiProperty(identifier=true)
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\SequenceGenerator(sequenceName="ingredient_to_meal_id_seq")
     * @ORM\Column(type="integer", name="id")
     */
    private ?int $id = null;

    /**
     * @Groups({"ingredient_to_meal_read", "ingredient_to_meal_write","ingredient_to_meal_update"})
     * @ORM\Column(type="integer",  name="ingredient_id", nullable=false)
     */
    private int $ingredientId;

    /**
     * @Groups({"ingredient_to_meal_read", "ingredient_to_meal_write","ingredient_to_meal_update"})
     * @ORM\Column(type="integer", name="meal_id", nullable=false)
     */
    private int $mealId;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getIngredientId(): int
    {
        return $this->ingredientId;
    }

    /**
     * @param int $ingredientId
     * @return IngredientToMeal
     */
    public function setIngredientId(int $ingredientId): IngredientToMeal
    {
        $this->ingredientId = $ingredientId;
        return $this;
    }

    /**
     * @return int
     */
    public function getMealId(): int
    {
        return $this->mealId;
    }

    /**
     * @param int $mealId
     * @return IngredientToMeal
     */
    public function setMealId(int $mealId): IngredientToMeal
    {
        $this->mealId = $mealId;
        return $this;
    }
}
