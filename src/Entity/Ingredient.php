<?php

namespace App\Entity;


use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Core\Database\HelperEntity\UserExtension;
use App\Entity\Interfaces\NutritionalValuesInterface;
use App\Entity\Traits\NutritionalValues;
use App\EntityProcesses\Ingredient\IngredientDeleteProcess;
use App\EntityProcesses\Ingredient\IngredientPostProcess;
use App\EntityProcesses\Ingredient\IngredientPutProcess;
use App\Repository\IngredientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(
    repositoryClass: IngredientRepository::class
)]
#[ApiResource]
#[Get(
    normalizationContext: ['groups' => ['ingredient_get']],
    security: "is_granted('ROLE_INGREDIENT_GET')",
)]
#[GetCollection(
    normalizationContext: ['groups' => ['ingredient_get']],
    security: "is_granted('ROLE_INGREDIENT_GET')",
)]
#[Post(
    normalizationContext: ['groups' => ['ingredient_get']],
    denormalizationContext: ['groups' => ['ingredient_post']],
    security: "is_granted('ROLE_INGREDIENT_POST')",
    processor: IngredientPostProcess::class
)]
#[Put(
    normalizationContext: ['groups' => ['ingredient_get']],
    denormalizationContext: ['groups' => ['ingredient_put']],
    security: "is_granted('ROLE_INGREDIENT_PUT')",
    processor: IngredientPutProcess::class
)]
#[Delete(
    denormalizationContext: ['groups' => ['ingredient_delete']],
    security: "is_granted('ROLE_INGREDIENT_DELETE', object)",
    processor: IngredientDeleteProcess::class
)]
class Ingredient extends UserExtension implements NutritionalValuesInterface
{
    use NutritionalValues;

    #[Orm\Id, ORM\Column(name: 'id', type:'integer'), ORM\GeneratedValue]
    #[Groups(['ingredient_get'])]
    private int $id;

    #[Orm\Column(name:'name',type: 'string')]
    #[Groups(['ingredient_get', 'ingredient_post', 'ingredient_put', 'ingredient_delete', 'ingredient_to_meal_read'])]
    private string $name;

    #[Orm\Column(name:'description',type: 'string', nullable: true)]
    #[Groups(['ingredient_get', 'ingredient_post', 'ingredient_put', 'ingredient_delete', 'ingredient_to_meal_read'])]
    private ?string $description = null;

    #[Orm\Column(name:'amount',type: 'float', nullable: true)]
    #[Groups(['ingredient_get', 'ingredient_post', 'ingredient_put', 'ingredient_delete', 'ingredient_to_meal_read'])]
    private ?float $amount = null;

    #[Orm\Column(name:'amount_type_id',type: 'integer', nullable: true)]
    #[Groups(['ingredient_get', 'ingredient_post', 'ingredient_put', 'ingredient_delete', 'ingredient_to_meal_read'])]
    private int $amountTypeId;

    #[Orm\Column(name:'divider_value',type: 'integer')]
    private int $dividerValue = 100;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Ingredient
     */
    public function setId(int $id): Ingredient
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Ingredient
     */
    public function setName(string $name): Ingredient
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return Ingredient
     */
    public function setDescription(?string $description): Ingredient
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * @param float|null $amount
     * @return Ingredient
     */
    public function setAmount(?float $amount): Ingredient
    {
        $this->amount = $amount;
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

    /**
     * @return float|null
     */
    public function getProtein(): ?float
    {
        return $this->protein;
    }

    /**
     * @param float|null $protein
     * @return Ingredient
     */
    public function setProtein(?float $protein): Ingredient
    {
        $this->protein = $protein;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getCarbohydrate(): ?float
    {
        return $this->carbohydrate;
    }

    /**
     * @param float|null $carbohydrate
     * @return Ingredient
     */
    public function setCarbohydrate(?float $carbohydrate): Ingredient
    {
        $this->carbohydrate = $carbohydrate;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getFat(): ?float
    {
        return $this->fat;
    }

    /**
     * @param float|null $fat
     * @return Ingredient
     */
    public function setFat(?float $fat): Ingredient
    {
        $this->fat = $fat;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getCalorie(): ?float
    {
        return $this->calorie;
    }

    /**
     * @param float|null $calorie
     * @return Ingredient
     */
    public function setCalorie(?float $calorie): Ingredient
    {
        $this->calorie = $calorie;
        return $this;
    }
}
