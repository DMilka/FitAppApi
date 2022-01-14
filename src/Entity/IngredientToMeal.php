<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\IngredientToMealRepository;

/**
 * @ApiResource(
 *      collectionOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"ingredient_to_meal_read"}}
 *          },
 *          "post"={
 *              "normalization_context"={"groups"={"ingredient_to_meal_read"}},
 *              "denormalization_context"={"groups"={"ingredient_to_meal_write"}}
 *          },
 *     },
 *     itemOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"ingredient_to_meal_read"}}
 *          },
 *          "put"={
 *              "normalization_context"={"groups"={"ingredient_to_meal_read"}},
 *              "denormalization_context"={"groups"={"ingredient_to_meal_update"}}
 *          },}
 * )
 * @ORM\Entity(repositoryClass=IngredientToMealRepository::class)
 */
class IngredientToMeal
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
