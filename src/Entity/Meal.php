<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\EntityProcesses\Meal\MealDeleteProcess;
use App\EntityProcesses\Meal\MealPostProcess;
use App\EntityProcesses\Meal\MealPutProcess;
use Doctrine\ORM\Mapping as ORM;
use App\Core\Database\HelperEntity\UserExtension;

#[ORM\Entity]
#[ApiResource]
#[Get(
    security: "is_granted('ROLE_MEAL_GET')",
)]
#[GetCollection(
    security: "is_granted('ROLE_MEAL_GET')",
)]
#[Post(
    security: "is_granted('ROLE_MEAL_POST')",
    processor: MealPostProcess::class
)]
#[Put(
    security: "is_granted('ROLE_MEAL_PUT')",
    processor: MealPutProcess::class
)]
#[Delete(
    security: "is_granted('ROLE_MEAL_DELETE', object)",
    processor: MealDeleteProcess::class
)]
class Meal extends UserExtension
{
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
     * @return Meal
     */
    public function setDescription(?string $description): Meal
    {
        $this->description = $description;
        return $this;
    }
}
