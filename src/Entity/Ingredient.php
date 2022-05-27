<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Core\Database\HelperEntity\UserExtension;
use App\Repository\IngredientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;

/**
 * @ApiResource(
 *      collectionOperations={
 *          "get"={
 *              "security"="is_granted('ROLE_INGREDIENT_GET')",
 *              "normalization_context"={"groups"={"ingredient_read"}}
 *          },
 *          "post"={
 *              "security"="is_granted('ROLE_INGREDIENT_POST')",
 *              "normalization_context"={"groups"={"ingredient_read"}},
 *              "denormalization_context"={"groups"={"ingredient_write"}}
 *          },
 *     },
 *     itemOperations={
 *          "get"={
 *              "security"="is_granted('ROLE_INGREDIENT_GET')",
 *              "normalization_context"={"groups"={"ingredient_read"}}
 *          },
 *          "put"={
 *              "security"="is_granted('ROLE_INGREDIENT_PUT')",
 *              "normalization_context"={"groups"={"ingredient_read"}},
 *              "denormalization_context"={"groups"={"ingredient_update"}}
 *          },
 *          "delete"={
 *              "security"="is_granted('ROLE_INGREDIENT_DELETE')",
 *              "denormalization_context"={"groups"={"ingredient_delete"}}
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass=IngredientRepository::class)
 * @ApiFilter(SearchFilter::class, properties={"name": "ipartial", "description": "ipartial"})
 * @ApiFilter(NumericFilter::class, properties={"amount","protein","carbohydrate","fat","calorie"})
 * @ApiFilter(OrderFilter::class, properties={"id","name", "description","amount","protein","carbohydrate","fat","amount_type_id","calorie"}, arguments={"orderParameterName"="order"})
 */
class Ingredient extends UserExtension
{
    /**
     * @Groups({"ingredient_read"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="id")
     */
    private int $id;

    /**
     * @Groups({"ingredient_read", "ingredient_write", "ingredient_update","ingredient_to_meal_read"})
     * @ORM\Column(type="string", length=255, name="name")
     */
    private string $name;

    /**
     * @Groups({"ingredient_read", "ingredient_write", "ingredient_update","ingredient_to_meal_read"})
     * @ORM\Column(type="string", length=255, nullable=true, name="description")
     */
    private ?string $description = null;

    /**
     * @Groups({"ingredient_read", "ingredient_write", "ingredient_update","ingredient_to_meal_read"})
     * @ORM\Column(type="integer", name="amount")
     */
    private ?int $amount = null;

    /**
     * @Groups({"ingredient_read", "ingredient_write", "ingredient_update","ingredient_to_meal_read"})
     * @ORM\Column(type="integer", nullable=true, name="protein")
     */
    private ?int $protein = null;

    /**
     * @Groups({"ingredient_read", "ingredient_write", "ingredient_update","ingredient_to_meal_read"})
     * @ORM\Column(type="integer", nullable=true, name="carbohydrate")
     */
    private ?int $carbohydrate = null;

    /**
     * @Groups({"ingredient_read", "ingredient_write", "ingredient_update","ingredient_to_meal_read"})
     * @ORM\Column(type="integer", nullable=true, name="fat")
     */
    private ?int $fat = null;

    /**
     * @Groups({"ingredient_read", "ingredient_write", "ingredient_update","ingredient_to_meal_read"})
     * @ORM\Column(type="integer", nullable=true, name="calorie")
     */
    private ?int $calorie = null;

    /**
     * @Groups({"ingredient_read", "ingredient_write", "ingredient_update","ingredient_to_meal_read"})
     * @ORM\Column(type="integer", nullable=false, name="amount_type_id")
     */
    private int $amountTypeId;

    /**
     * @Groups({"ingredient_read","ingredient_to_meal_read"})
     * @ORM\Column(type="integer", nullable=false, name="divider_value")
     */
    private int $dividerValue = 100;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmountTypeId(): int
    {
        return $this->amountTypeId;
    }

    /**
     * @param int $amountTypeId
     * @return Ingredient
     */
    public function setAmountTypeId(int $amountTypeId): Ingredient
    {
        $this->amountTypeId = $amountTypeId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getAmount(): ?int
    {
        return $this->amount;
    }

    /**
     * @param int|null $amount
     * @return Ingredient
     */
    public function setAmount(?int $amount): Ingredient
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getProtein(): ?int
    {
        return $this->protein;
    }

    /**
     * @param int|null $protein
     * @return Ingredient
     */
    public function setProtein(?int $protein): Ingredient
    {
        $this->protein = $protein;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCarbohydrate(): ?int
    {
        return $this->carbohydrate;
    }

    /**
     * @param int|null $carbohydrate
     * @return Ingredient
     */
    public function setCarbohydrate(?int $carbohydrate): Ingredient
    {
        $this->carbohydrate = $carbohydrate;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getFat(): ?int
    {
        return $this->fat;
    }

    /**
     * @param int|null $fat
     * @return Ingredient
     */
    public function setFat(?int $fat): Ingredient
    {
        $this->fat = $fat;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCalorie(): ?int
    {
        return $this->calorie;
    }

    /**
     * @param int|null $calorie
     * @return Ingredient
     */
    public function setCalorie(?int $calorie): Ingredient
    {
        $this->calorie = $calorie;
        return $this;
    }

    /**
     * @return int
     */
    public function getDividerValue(): int
    {
        return $this->dividerValue;
    }

    /**
     * @param int $dividerValue
     * @return Ingredient
     */
    public function setDividerValue(int $dividerValue): Ingredient
    {
        $this->dividerValue = $dividerValue;
        return $this;
    }


}
