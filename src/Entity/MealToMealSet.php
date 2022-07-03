<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Core\Database\HelperEntity\SoftDelete;
use App\Repository\MealToMealSetRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;

/**
 * @ApiResource(
 *      collectionOperations={
 *          "get"={
 *              "security"="is_granted('ROLE_MEAL_TO_MEAL_SET_GET')",
 *              "normalization_context"={"groups"={"meal_to_meal_set_read"}}
 *          },
 *          "post"={
 *              "security"="is_granted('ROLE_MEAL_TO_MEAL_SET_POST')",
 *              "normalization_context"={"groups"={"meal_to_meal_set_read"}},
 *              "denormalization_context"={"groups"={"meal_to_meal_set_write"}}
 *          },
 *     },
 *     itemOperations={
 *          "get"={
 *              "security"="is_granted('ROLE_MEAL_TO_MEAL_SET_GET')",
 *              "normalization_context"={"groups"={"meal_to_meal_set_read"}}
 *          },
 *          "put"={
 *              "security"="is_granted('ROLE_MEAL_TO_MEAL_SET_PUT')",
 *              "normalization_context"={"groups"={"meal_to_meal_set_read"}},
 *              "denormalization_context"={"groups"={"meal_to_meal_set_update"}}
 *          },
 *          "delete"={
 *              "security"="is_granted('ROLE_MEAL_TO_MEAL_SET_DELETE')",
 *              "denormalization_context"={"groups"={"meal_set_delete"}}
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass=MealToMealSetRepository::class)
 * @ApiFilter(NumericFilter::class, properties={"mealSetId"})
 */
class MealToMealSet extends SoftDelete
{
    /**
     * @Groups({"meal_to_meal_set_read"})
     * @ApiProperty(identifier=true)
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\SequenceGenerator(sequenceName="meal_to_meal_set_id_seq")
     * @ORM\Column(type="integer", name="id")
     */
    private ?int $id = null;

    /**
     * @Groups({"meal_to_meal_set_read", "meal_to_meal_set_write","meal_to_meal_set_update"})
     * @ORM\Column(type="integer",  name="meal_set_id", nullable=false)
     */
    private int $mealSetId;

    /**
     * @Groups({"meal_to_meal_set_read", "meal_to_meal_set_write","meal_to_meal_set_update"})
     * @ORM\Column(type="integer", name="meal_id", nullable=true)
     */
    private ?int $mealId = null;

    /**
     * @ApiSubresource
     * @Groups({"meal_to_meal_set_read", "meal_to_meal_set_write","meal_to_meal_set_update"})
     * @ORM\OneToOne(targetEntity="Meal")
     * @ORM\JoinColumn(name="meal_id",referencedColumnName="id")
     */
    private ?Meal $meal = null;

    /**
     * @Groups({"meal_to_meal_set_read", "meal_to_meal_set_write","meal_to_meal_set_update"})
     * @ORM\Column(type="integer", name="ingredient_id", nullable=true)
     */
    private ?int $ingredientId = null;

    /**
     * @ApiSubresource
     * @Groups({"meal_to_meal_set_read", "meal_to_meal_set_write","meal_to_meal_set_update"})
     * @ORM\OneToOne(targetEntity="Ingredient")
     * @ORM\JoinColumn(name="ingredient_id",referencedColumnName="id")
     */
    private ?Ingredient $ingredient = null;

    /**
     * @Groups({"meal_to_meal_set_read", "meal_to_meal_set_write","meal_to_meal_set_update"})
     * @ORM\Column(type="string",  name="amount", nullable=true)
     */
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
