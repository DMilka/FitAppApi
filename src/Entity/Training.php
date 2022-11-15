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
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(
    repositoryClass: TrainingRepository::class
)]
#[ApiResource]
#[Get(
    normalizationContext: ['groups' => ['training_get']],
    security: "is_granted('ROLE_TRAINING_GET')",
)]
#[GetCollection(
    normalizationContext: ['groups' => ['training_get']],
    security: "is_granted('ROLE_TRAINING_GET')",
)]
#[Post(
    normalizationContext: ['groups' => ['training_get']],
    denormalizationContext: ['groups' => ['training_post']],
    security: "is_granted('ROLE_TRAINING_POST')",
    processor: TrainingPostProcess::class
)]
#[Put(
    normalizationContext: ['groups' => ['training_get']],
    denormalizationContext: ['groups' => ['training_put']],
    security: "is_granted('ROLE_TRAINING_PUT')",
    processor: TrainingPutProcess::class
)]
#[Delete(
    denormalizationContext: ['groups' => ['training_delete']],
    security: "is_granted('ROLE_TRAINING_DELETE', object)",
    processor: TrainingDeleteProcess::class
)]
class Training extends UserExtension
{
    #[Orm\Id, ORM\Column(name: 'id', type:'integer'), ORM\GeneratedValue]
    #[Groups(['training_get'])]
    private ?int $id = null;

    #[Orm\Column(name:'name',type: 'string')]
    #[Groups(['training_get', 'training_post', 'training_put', 'training_delete'])]
    private string $name;

    #[Orm\Column(name:'description',type: 'string', nullable: true)]
    #[Groups(['training_get', 'training_post', 'training_put', 'training_delete'])]
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
