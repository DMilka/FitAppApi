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
use App\EntityProcesses\MealSet\MealSetDeleteProcess;
use App\EntityProcesses\MealSet\MealSetPostProcess;
use App\EntityProcesses\MealSet\MealSetPutProcess;
use App\Repository\MealSetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(
    repositoryClass: MealSetRepository::class
)]
#[ApiResource]
#[Get(
    security: "is_granted('ROLE_MEAL_SET_GET')",
)]
#[GetCollection(
    security: "is_granted('ROLE_MEAL_SET_GET')",
)]
#[Post(
    security: "is_granted('ROLE_MEAL_SET_POST')",
    processor: MealSetPostProcess::class
)]
#[Put(
    security: "is_granted('ROLE_MEAL_SET_PUT')",
    processor: MealSetPutProcess::class
)]
#[Delete(
    security: "is_granted('ROLE_MEAL_SET_DELETE', object)",
    processor: MealSetDeleteProcess::class
)]
class MealSet extends UserExtension implements NutritionalValuesInterface
{
    use NutritionalValues;

    #[Orm\Id, ORM\Column(name: 'id', type:'integer'), ORM\GeneratedValue]
    private ?int $id = null;

    #[Orm\Column(name:'name',type: 'string')]
    private string $name;

    #[Orm\Column(name:'description',type: 'string', nullable: true)]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return MealSet
     */
    public function setDescription(?string $description): MealSet
    {
        $this->description = $description;
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
     * @return MealSet
     */
    public function setProtein(?float $protein): MealSet
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
     * @return MealSet
     */
    public function setCarbohydrate(?float $carbohydrate): MealSet
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
     * @return MealSet
     */
    public function setFat(?float $fat): MealSet
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
     * @return MealSet
     */
    public function setCalorie(?float $calorie): MealSet
    {
        $this->calorie = $calorie;
        return $this;
    }
}
