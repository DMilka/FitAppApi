<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Entity\Interfaces\NutritionalValuesInterface;
use App\Entity\Traits\NutritionalValues;
use App\EntityProcesses\Meal\MealDeleteProcess;
use App\EntityProcesses\Meal\MealPostProcess;
use App\EntityProcesses\Meal\MealPutProcess;
use App\Repository\MealRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Core\Database\HelperEntity\UserExtension;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(
    repositoryClass: MealRepository::class
)]
#[ApiResource]
#[Get(
    normalizationContext: ['groups' => ['meal_get']],
    security: "is_granted('ROLE_MEAL_GET')",
)]
#[GetCollection(
    normalizationContext: ['groups' => ['meal_get']],
    security: "is_granted('ROLE_MEAL_GET')",
)]
#[Post(
    normalizationContext: ['groups' => ['meal_get']],
    denormalizationContext: ['groups' => ['meal_post']],
    security: "is_granted('ROLE_MEAL_POST')",
    processor: MealPostProcess::class
)]
#[Put(
    normalizationContext: ['groups' => ['meal_get']],
    denormalizationContext: ['groups' => ['meal_put']],
    security: "is_granted('ROLE_MEAL_PUT')",
    processor: MealPutProcess::class
)]
#[Delete(
    denormalizationContext: ['groups' => ['meal_delete']],
    security: "is_granted('ROLE_MEAL_DELETE', object)",
    processor: MealDeleteProcess::class
)]
class Meal extends UserExtension implements NutritionalValuesInterface
{
    use NutritionalValues;

    #[Orm\Id, ORM\Column(name: 'id', type:'integer'), ORM\GeneratedValue]
    #[Groups(['meal_get'])]
    private ?int $id = null;

    #[Orm\Column(name:'name',type: 'string')]
    #[Groups(['meal_get', 'meal_post', 'meal_put', 'meal_delete'])]
    private string $name;

    #[Orm\Column(name:'description',type: 'string', nullable: true)]
    #[Groups(['meal_get', 'meal_post', 'meal_put', 'meal_delete'])]
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
     * @return Meal
     */
    public function setDescription(?string $description): Meal
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
     * @return Meal
     */
    public function setProtein(?float $protein): Meal
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
     * @return Meal
     */
    public function setCarbohydrate(?float $carbohydrate): Meal
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
     * @return Meal
     */
    public function setFat(?float $fat): Meal
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
     * @return Meal
     */
    public function setCalorie(?float $calorie): Meal
    {
        $this->calorie = $calorie;
        return $this;
    }
}
