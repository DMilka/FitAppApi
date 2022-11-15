<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Core\Database\HelperEntity\UserExtension;
use App\EntityProcesses\TrainingSet\TrainingSetDeleteProcess;
use App\EntityProcesses\TrainingSet\TrainingSetPostProcess;
use App\EntityProcesses\TrainingSet\TrainingSetPutProcess;
use App\Repository\TrainingSetRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(
    repositoryClass: TrainingSetRepository::class
)]
#[ApiResource]
#[Get(
    normalizationContext: ['groups' => ['training_set_get']],
    security: "is_granted('ROLE_TRAINING_SET_GET')",
)]
#[GetCollection(
    normalizationContext: ['groups' => ['training_set_get']],
    security: "is_granted('ROLE_TRAINING_SET_GET')",
)]
#[Post(
    normalizationContext: ['groups' => ['training_set_get']],
    denormalizationContext: ['groups' => ['training_set_post']],
    security: "is_granted('ROLE_TRAINING_SET_POST')",
    processor: TrainingSetPostProcess::class
)]
#[Put(
    normalizationContext: ['groups' => ['training_set_get']],
    denormalizationContext: ['groups' => ['training_set_put']],
    security: "is_granted('ROLE_TRAINING_SET_PUT')",
    processor: TrainingSetPutProcess::class
)]
#[Delete(
    denormalizationContext: ['groups' => ['training_set_delete']],
    security: "is_granted('ROLE_TRAINING_SET_DELETE', object)",
    processor: TrainingSetDeleteProcess::class
)]
class TrainingSet extends UserExtension
{
    #[Orm\Id, ORM\Column(name: 'id', type:'integer'), ORM\GeneratedValue]
    #[Groups(['training_set_get'])]
    private ?int $id = null;

    #[Orm\Column(name:'name',type: 'string')]
    #[Groups(['training_set_get', 'training_set_post', 'training_set_put', 'training_set_delete'])]
    private string $name;

    #[Orm\Column(name:'description',type: 'string', nullable: true)]
    #[Groups(['training_set_get', 'training_set_post', 'training_set_put', 'training_set_delete'])]
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
     * @return TrainingSet
     */
    public function setName(string $name): TrainingSet
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
     * @return TrainingSet
     */
    public function setDescription(?string $description): TrainingSet
    {
        $this->description = $description;
        return $this;
    }
}
