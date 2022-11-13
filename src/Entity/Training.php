<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\EntityProcesses\Training\TrainingDeleteProcess;
use App\EntityProcesses\Training\TrainingPostProcess;
use App\EntityProcesses\Training\TrainingPutProcess;
use App\Repository\TrainingRepository;
use Doctrine\ORM\Mapping as ORM;

use App\Core\Database\HelperEntity\UserExtension;

#[ORM\Entity(
    repositoryClass: TrainingRepository::class
)]
#[ApiResource]
#[Get(
    security: "is_granted('ROLE_TRAINING_GET')",
)]
#[GetCollection(
    security: "is_granted('ROLE_TRAINING_GET')",
)]
#[Post(
    security: "is_granted('ROLE_TRAINING_POST')",
    processor: TrainingPostProcess::class
)]
#[Put(
    security: "is_granted('ROLE_TRAINING_PUT')",
    processor: TrainingPutProcess::class
)]
#[Delete(
    security: "is_granted('ROLE_TRAINING_DELETE', object)",
    processor: TrainingDeleteProcess::class
)]
class Training extends UserExtension
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

    /**
     * @param string $name
     * @return Training
     */
    public function setName(string $name): Training
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
     * @return Training
     */
    public function setDescription(?string $description): Training
    {
        $this->description = $description;
        return $this;
    }
}
