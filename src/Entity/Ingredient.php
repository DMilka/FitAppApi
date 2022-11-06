<?php

namespace App\Entity;


use App\Core\Database\HelperEntity\UserExtension;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

///**
// * @ApiResource(
// *      collectionOperations={
// *          "get"={
// *              "security"="is_granted('ROLE_INGREDIENT_GET')",
// *              "normalization_context"={"groups"={"ingredient_read"}}
// *          },
// *          "post"={
// *              "security"="is_granted('ROLE_INGREDIENT_POST')",
// *              "normalization_context"={"groups"={"ingredient_read"}},
// *              "denormalization_context"={"groups"={"ingredient_write"}}
// *          },
// *     },
// *     itemOperations={
// *          "get"={
// *              "security"="is_granted('ROLE_INGREDIENT_GET')",
// *              "normalization_context"={"groups"={"ingredient_read"}}
// *          },
// *          "put"={
// *              "security"="is_granted('ROLE_INGREDIENT_PUT')",
// *              "normalization_context"={"groups"={"ingredient_read"}},
// *              "denormalization_context"={"groups"={"ingredient_update"}}
// *          },
// *          "delete"={
// *              "security"="is_granted('ROLE_INGREDIENT_DELETE')",
// *              "denormalization_context"={"groups"={"ingredient_delete"}}
// *          }
// *     }
// * )
// * @ORM\Entity(repositoryClass=IngredientRepository::class)
// * @ApiFilter(SearchFilter::class, properties={"name": "ipartial", "description": "ipartial"})
// * @ApiFilter(NumericFilter::class, properties={"amount","protein","carbohydrate","fat","calorie"})
// * @ApiFilter(OrderFilter::class, properties={"id","name", "description","amount","protein","carbohydrate","fat","amount_type_id","calorie"}, arguments={"orderParameterName"="order"})
// */

#[ORM\Entity]
#[ApiResource]
class Ingredient extends UserExtension
{

    #[Orm\Id, ORM\Column(name: 'id', type:'integer'), ORM\GeneratedValue]
    private int $id;

    #[Orm\Column(name:'name',type: 'string')]
    private string $name;

    #[Orm\Column(name:'description',type: 'string', nullable: true)]
    private ?string $description = null;

    #[Orm\Column(name:'amount',type: 'integer', nullable: true)]
    private ?int $amount = null;

    #[Orm\Column(name:'protein',type: 'integer', nullable: true)]
    private ?int $protein = null;

    #[Orm\Column(name:'carbohydrate',type: 'integer', nullable: true)]
    private ?int $carbohydrate = null;

    #[Orm\Column(name:'fat',type: 'integer', nullable: true)]
    private ?int $fat = null;

    #[Orm\Column(name:'calorie',type: 'integer', nullable: true)]
    private ?int $calorie = null;

    #[Orm\Column(name:'amount_type_id',type: 'integer', nullable: true)]
    private int $amountTypeId;

    #[Orm\Column(name:'divider_value',type: 'integer')]
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
