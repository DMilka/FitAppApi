<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\IngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *      collectionOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"ingredient_read"}}
 *          },
 *          "post"={
 *              "normalization_context"={"groups"={"ingredient_read"}},
 *              "denormalization_context"={"groups"={"ingredient_write"}}
 *          },
 *     },
 *     itemOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"ingredient_read"}}
 *          },
 *          "put"={
 *              "normalization_context"={"groups"={"ingredient_read"}},
 *              "denormalization_context"={"groups"={"ingredient_update"}}
 *          },}
 * )
 * @ORM\Entity(repositoryClass=IngredientRepository::class)
 */
class Ingredient
{
    /**
     * @Groups({"ingredient_read"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="id")
     */
    private int $id;

    /**
     * @Groups({"ingredient_read", "ingredient_write"})
     * @ORM\Column(type="string", length=255, name="name")
     */
    private string $name;

    /**
     * @Groups({"ingredient_read", "ingredient_write"})
     * @ORM\Column(type="string", length=255, nullable=true, name="description")
     */
    private ?string $description = null;

    /**
     * @Groups({"ingredient_read", "ingredient_write"})
     * @ORM\Column(type="float", name="amount")
     */
    private ?float $amount = null;

    /**
     * @Groups({"ingredient_read", "ingredient_write"})
     * @ORM\Column(type="float", nullable=true, name="protein")
     */
    private ?float $protein = null;

    /**
     * @Groups({"ingredient_read", "ingredient_write"})
     * @ORM\Column(type="float", nullable=true, name="carbohydrate")
     */
    private ?float $carbohydrate = null;

    /**
     * @Groups({"ingredient_read", "ingredient_write"})
     * @ORM\Column(type="float", nullable=true, name="fat")
     */
    private ?float $fat = null;

    /**
     * @Groups({"ingredient_read", "ingredient_write"})
     * @ORM\Column(type="float", nullable=true, name="calorie")
     */
    private ?float $calorie = null;

    /**
     * @Groups({"ingredient_write"})
     * @ORM\Column(type="integer", nullable=false, name="user_id")
     * @ORM\ManyToOne(targetEntity=Users::class)
     * @ORM\JoinColumn(nullable=false,referencedColumnName="id")
     */
    private int $userId;

    /**
     * @Groups({"ingredient_read", "ingredient_write"})
     * @ORM\Column(type="integer", nullable=false, name="amount_type_id")
     */
    private int $amountTypeId;

    /**
     * @Groups({"ingredient_read", "ingredient_write"})
     * @ORM\ManyToOne(targetEntity=AmountType::class)
     * @ORM\JoinColumn(nullable=false,referencedColumnName="id")
     */
    private AmountType $amountType;


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

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getProtein(): ?float
    {
        return $this->protein;
    }

    public function setProtein(?float $protein): self
    {
        $this->protein = $protein;

        return $this;
    }

    public function getCarbohydrate(): ?float
    {
        return $this->carbohydrate;
    }

    public function setCarbohydrate(?float $carbohydrate): self
    {
        $this->carbohydrate = $carbohydrate;

        return $this;
    }

    public function getFat(): ?float
    {
        return $this->fat;
    }

    public function setFat(?float $fat): self
    {
        $this->fat = $fat;

        return $this;
    }

    public function getCalorie(): ?float
    {
        return $this->calorie;
    }

    public function setCalorie(?float $calorie): self
    {
        $this->calorie = $calorie;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

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
     * @return AmountType
     */
    public function getAmountType(): AmountType
    {
        return $this->amountType;
    }

    /**
     * @param AmountType $amountType
     * @return Ingredient
     */
    public function setAmountType(AmountType $amountType): Ingredient
    {
        $this->amountType = $amountType;
        return $this;
    }




}
