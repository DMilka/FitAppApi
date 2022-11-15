<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Core\Database\HelperEntity\SoftDelete;
use App\EntityProcesses\MealToMealSet\MealToMealSetDeleteProcess;
use App\EntityProcesses\MealToMealSet\MealToMealSetPostProcess;
use App\EntityProcesses\MealToMealSet\MealToMealSetPutProcess;
use App\Repository\MealToMealSetRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(
    repositoryClass: MealToMealSetRepository::class
)]
#[ApiResource]
#[Get(
    normalizationContext: ['groups' => ['meal_to_meal_set_get']],
    security: "is_granted('ROLE_MEAL_TO_MEAL_SET_GET')",
)]
#[GetCollection(
    normalizationContext: ['groups' => ['meal_to_meal_set_get']],
    security: "is_granted('ROLE_MEAL_TO_MEAL_SET_GET')",
)]
#[Post(
    normalizationContext: ['groups' => ['meal_to_meal_set_get']],
    denormalizationContext: ['groups' => ['meal_to_meal_set_post']],
    security: "is_granted('ROLE_MEAL_TO_MEAL_SET_POST')",
    processor: MealToMealSetPostProcess::class
)]
#[Put(
    normalizationContext: ['groups' => ['meal_to_meal_set_get']],
    denormalizationContext: ['groups' => ['meal_to_meal_set_put']],
    security: "is_granted('ROLE_MEAL_TO_MEAL_SET_PUT')",
    processor: MealToMealSetPutProcess::class
)]
#[Delete(
    denormalizationContext: ['groups' => ['meal_to_meal_set_post']],
    security: "is_granted('ROLE_MEAL_TO_MEAL_SET_DELETE', object)",
    processor: MealToMealSetDeleteProcess::class
)]
class MealToMealSet extends SoftDelete
{
    #[Orm\Id, ORM\Column(name: 'id', type:'integer'), ORM\GeneratedValue]
    #[Groups(['meal_to_meal_set_get'])]
    private ?int $id = null;

    #[Orm\Column(name:'meal_set_id',type: 'integer')]
    #[Groups(['meal_to_meal_set_get', 'meal_to_meal_set_post', 'meal_to_meal_set_put', 'meal_to_meal_set_delete'])]
    private int $mealSetId;

    #[Orm\Column(name:'meal_id',type: 'integer',nullable: true)]
    #[Groups(['meal_to_meal_set_get', 'meal_to_meal_set_post', 'meal_to_meal_set_put', 'meal_to_meal_set_delete'])]
    private ?int $mealId = null;

    #[ORM\OneToOne(targetEntity: Meal::class, cascade: ['persist'])]
    #[Groups(['meal_to_meal_set_get', 'meal_to_meal_set_post', 'meal_to_meal_set_put', 'meal_to_meal_set_delete'])]
    private ?Meal $meal = null;

    #[Orm\Column(name:'ingredient_id',type: 'integer',nullable: true)]
    #[Groups(['meal_to_meal_set_get', 'meal_to_meal_set_post', 'meal_to_meal_set_put', 'meal_to_meal_set_delete'])]
    private ?int $ingredientId = null;

    #[ORM\OneToOne(targetEntity: Ingredient::class, cascade: ['persist'])]
    #[Groups(['meal_to_meal_set_get', 'meal_to_meal_set_post', 'meal_to_meal_set_put', 'meal_to_meal_set_delete'])]
    private ?Ingredient $ingredient = null;

    #[Orm\Column(name:'amount',type: 'string', nullable: true)]
    #[Groups(['meal_to_meal_set_get', 'meal_to_meal_set_post', 'meal_to_meal_set_put', 'meal_to_meal_set_delete'])]
    private ?string $amount = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return MealToMealSet
     */
    public function setId(?int $id): MealToMealSet
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getMealSetId(): int
    {
        return $this->mealSetId;
    }

    /**
     * @param int $mealSetId
     * @return MealToMealSet
     */
    public function setMealSetId(int $mealSetId): MealToMealSet
    {
        $this->mealSetId = $mealSetId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMealId(): ?int
    {
        return $this->mealId;
    }

    /**
     * @param int|null $mealId
     * @return MealToMealSet
     */
    public function setMealId(?int $mealId): MealToMealSet
    {
        $this->mealId = $mealId;
        return $this;
    }

    /**
     * @return Meal|null
     */
    public function getMeal(): ?Meal
    {
        return $this->meal;
    }

    /**
     * @param Meal|null $meal
     * @return MealToMealSet
     */
    public function setMeal(?Meal $meal): MealToMealSet
    {
        $this->meal = $meal;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getIngredientId(): ?int
    {
        return $this->ingredientId;
    }

    /**
     * @param int|null $ingredientId
     * @return MealToMealSet
     */
    public function setIngredientId(?int $ingredientId): MealToMealSet
    {
        $this->ingredientId = $ingredientId;
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
     * @return MealToMealSet
     */
    public function setIngredient(?Ingredient $ingredient): MealToMealSet
    {
        $this->ingredient = $ingredient;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAmount(): ?string
    {
        return $this->amount;
    }

    /**
     * @param string|null $amount
     * @return MealToMealSet
     */
    public function setAmount(?string $amount): MealToMealSet
    {
        $this->amount = $amount;
        return $this;
    }


}
