<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use App\Core\Database\HelperEntity\SoftDelete;
///**
// * @ApiResource(
// *      collectionOperations={
// *          "get"={
// *              "security"="is_granted('ROLE_INGREDIENT_TO_MEAL_GET')",
// *              "normalization_context"={"groups"={"ingredient_to_meal_read"}}
// *          }
// *     },
// *     itemOperations={
// *          "get"={
// *              "security"="is_granted('ROLE_INGREDIENT_TO_MEAL_GET')",
// *              "normalization_context"={"groups"={"ingredient_to_meal_read"}}
// *          }
// *     }
// * )
// * @ORM\Entity(repositoryClass=IngredientToMealRepository::class)
// * @ApiFilter(NumericFilter::class, properties={"mealId"})
// */

#[ORM\Entity]
#[ApiResource]
class IngredientToMeal extends SoftDelete
{
    #[Orm\Id, ORM\Column(name: 'id', type:'integer'), ORM\GeneratedValue]
    private ?int $id = null;

    #[Orm\Column(name:'ingredient_id',type: 'integer')]
    private int $ingredientId;

    #[ORM\OneToMany(mappedBy: 'ingredientToMeal', targetEntity: Ingredient::class, cascade: ['persist'])]
    private ?Ingredient $ingredient = null;

    #[Orm\Column(name:'meal_id', type: 'integer')]
    private int $mealId;

    #[Orm\Column(name:'amount',type: 'integer')]
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
