<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Core\Database\HelperEntity\SoftDelete;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

///**
// * @ApiResource(
// *      collectionOperations={
// *          "get"={
// *              "security"="is_granted('ROLE_MEAL_TO_MEAL_SET_GET')",
// *              "normalization_context"={"groups"={"meal_to_meal_set_read"}}
// *          },
// *          "post"={
// *              "security"="is_granted('ROLE_MEAL_TO_MEAL_SET_POST')",
// *              "normalization_context"={"groups"={"meal_to_meal_set_read"}},
// *              "denormalization_context"={"groups"={"meal_to_meal_set_write"}}
// *          },
// *     },
// *     itemOperations={
// *          "get"={
// *              "security"="is_granted('ROLE_MEAL_TO_MEAL_SET_GET')",
// *              "normalization_context"={"groups"={"meal_to_meal_set_read"}}
// *          },
// *          "put"={
// *              "security"="is_granted('ROLE_MEAL_TO_MEAL_SET_PUT')",
// *              "normalization_context"={"groups"={"meal_to_meal_set_read"}},
// *              "denormalization_context"={"groups"={"meal_to_meal_set_update"}}
// *          },
// *          "delete"={
// *              "security"="is_granted('ROLE_MEAL_TO_MEAL_SET_DELETE')",
// *              "denormalization_context"={"groups"={"meal_set_delete"}}
// *          }
// *     }
// * )
// * @ORM\Entity(repositoryClass=MealToMealSetRepository::class)
// * @ApiFilter(NumericFilter::class, properties={"mealSetId"})
// */

#[ORM\Entity]
#[ApiResource]
class MealToMealSet extends SoftDelete
{
    #[Orm\Id, ORM\Column(name: 'id', type:'integer'), ORM\GeneratedValue]
    private ?int $id = null;

    #[Orm\Column(name:'meal_set_id',type: 'integer')]
    private int $mealSetId;

    #[Orm\Column(name:'meal_id',type: 'integer',nullable: true)]
    private ?int $mealId = null;

    #[ORM\OneToMany(mappedBy: 'mealToMealSet', targetEntity: Meal::class, cascade: ['persist'])]
    private ?Meal $meal = null;

    #[Orm\Column(name:'ingredient_id',type: 'integer',nullable: true)]
    private ?int $ingredientId = null;

    #[ORM\OneToMany(mappedBy: 'mealToMealSet', targetEntity: Ingredient::class, cascade: ['persist'])]
    private ?Ingredient $ingredient = null;

    #[Orm\Column(name:'amount',type: 'string', nullable: true)]
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
