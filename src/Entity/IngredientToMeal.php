<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Core\Database\HelperEntity\SoftDelete;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\IngredientToMealRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;

/**
 * @ApiResource(
 *      collectionOperations={
 *          "get"={
 *              "security"="is_granted('ROLE_INGREDIENT_TO_MEAL_GET')",
 *              "normalization_context"={"groups"={"ingredient_to_meal_read"}}
 *          }
 *     },
 *     itemOperations={
 *          "get"={
 *              "security"="is_granted('ROLE_INGREDIENT_TO_MEAL_GET')",
 *              "normalization_context"={"groups"={"ingredient_to_meal_read"}}
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass=IngredientToMealRepository::class)
 * @ApiFilter(NumericFilter::class, properties={"mealId"})
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
     * @ApiSubresource
     * @Groups({"ingredient_to_meal_read", "ingredient_to_meal_write","ingredient_to_meal_update"})
     * @ORM\OneToOne(targetEntity="Ingredient")
     * @ORM\JoinColumn(name="ingredient_id",referencedColumnName="id")
     */
    private ?Ingredient $ingredient = null;

    /**
     * @Groups({"ingredient_to_meal_read", "ingredient_to_meal_write","ingredient_to_meal_update"})
     * @ORM\Column(type="integer", name="meal_id", nullable=false)
     */
    private int $mealId;

    /**
     * @Groups({"ingredient_to_meal_read", "ingredient_to_meal_write","ingredient_to_meal_update"})
     * @ORM\Column(type="integer", name="amount", nullable=false)
     */
    private int $amount = 0;

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

    /**
     * @return Ingredient|null
     */
    public function getIngredient(): ?Ingredient
    {
        return $this->ingredient;
    }

    /**
     * @param Ingredient|null $ingredient
     * @return IngredientToMeal
     */
    public function setIngredient(?Ingredient $ingredient): IngredientToMeal
    {
        $this->ingredient = $ingredient;
        return $this;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     * @return IngredientToMeal
     */
    public function setAmount(int $amount): IngredientToMeal
    {
        $this->amount = $amount;
        return $this;
    }
}
