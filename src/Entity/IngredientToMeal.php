<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\EntityProcesses\IngredientToMeal\IngredientToMealDeleteProcess;
use App\EntityProcesses\IngredientToMeal\IngredientToMealPostProcess;
use App\EntityProcesses\IngredientToMeal\IngredientToMealPutProcess;
use App\Repository\IngredientToMealRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Core\Database\HelperEntity\SoftDelete;

#[ORM\Entity(
    repositoryClass: IngredientToMealRepository::class
)]
#[ApiResource]
#[Get(
    security: "is_granted('ROLE_INGREDIENT_TO_MEAL_GET')",
)]
#[GetCollection(
    security: "is_granted('ROLE_INGREDIENT_TO_MEAL_GET')",
)]
#[Post(
    security: "is_granted('ROLE_INGREDIENT_TO_MEAL_POST')",
    processor: IngredientToMealPostProcess::class
)]
#[Put(
    security: "is_granted('ROLE_INGREDIENT_TO_MEAL_PUT')",
    processor: IngredientToMealPutProcess::class
)]
#[Delete(
    security: "is_granted('ROLE_INGREDIENT_TO_MEAL_DELETE', object)",
    processor: IngredientToMealDeleteProcess::class
)]
class IngredientToMeal extends SoftDelete
{
    #[Orm\Id, ORM\Column(name: 'id', type:'integer'), ORM\GeneratedValue]
    private ?int $id = null;

    #[Orm\Column(name:'ingredient_id',type: 'integer')]
    private int $ingredientId;

    #[ORM\OneToOne(mappedBy: 'ingredientToMeal', targetEntity: Ingredient::class, cascade: ['persist'])]
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
