<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\EntityProcesses\TrainingSetToSchedule\TrainingSetToScheduleDeleteProcess;
use App\EntityProcesses\TrainingSetToSchedule\TrainingSetToSchedulePostProcess;
use App\EntityProcesses\TrainingSetToSchedule\TrainingSetToSchedulePutProcess;
use App\Repository\TrainingSetToScheduleRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Core\Database\HelperEntity\SoftDelete;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(
    repositoryClass: TrainingSetToScheduleRepository::class
)]
#[ApiResource]
#[Get(
    normalizationContext: ['groups' => ['training_set_to_schedule_get']],
    security: "is_granted('ROLE_TRAINING_SET_TO_SCHEDULE_GET')",
)]
#[GetCollection(
    normalizationContext: ['groups' => ['training_set_to_schedule_get']],
    security: "is_granted('ROLE_TRAINING_SET_TO_SCHEDULE_GET')",
)]
#[Post(
    normalizationContext: ['groups' => ['training_set_to_schedule_get']],
    denormalizationContext: ['groups' => ['training_set_to_schedule_post']],
    security: "is_granted('ROLE_TRAINING_SET_TO_SCHEDULE_POST')",
    processor: TrainingSetToSchedulePostProcess::class
)]
#[Put(
    normalizationContext: ['groups' => ['training_set_to_schedule_get']],
    denormalizationContext: ['groups' => ['training_set_to_schedule_put']],
    security: "is_granted('ROLE_TRAINING_SET_TO_SCHEDULE_PUT')",
    processor: TrainingSetToSchedulePutProcess::class
)]
#[Delete(
    denormalizationContext: ['groups' => ['training_set_to_schedule_delete']],
    security: "is_granted('ROLE_TRAINING_SET_TO_SCHEDULE_DELETE', object)",
    processor: TrainingSetToScheduleDeleteProcess::class
)]
class TrainingSetToSchedule extends SoftDelete
{
    #[Orm\Id, ORM\Column(name: 'id', type:'integer'), ORM\GeneratedValue]
    #[Groups(['training_set_to_schedule_get', 'training_set_to_schedule_post','training_set_to_schedule_put', 'training_set_to_schedule_delete'])]
    private ?int $id = null;

    #[Orm\Column(name:'training_set_id',type: 'integer')]
    #[Groups(['training_set_to_schedule_get', 'training_set_to_schedule_post','training_set_to_schedule_put', 'training_set_to_schedule_delete'])]
    private int $trainingSetId;

    #[ORM\OneToOne(targetEntity: TrainingSet::class, cascade: ['persist'])]
    #[Groups(['training_set_to_schedule_get', 'training_set_to_schedule_post','training_set_to_schedule_put', 'training_set_to_schedule_delete'])]
    private ?TrainingSet $trainingSet = null;

    #[Orm\Column(name:'schedule_id', type: 'integer')]
    #[Groups(['training_set_to_schedule_get', 'training_set_to_schedule_post','training_set_to_schedule_put', 'training_set_to_schedule_delete'])]
    private int $scheduleId;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getTrainingSetId(): int
    {
        return $this->trainingSetId;
    }

    /**
     * @param int $trainingSetId
     * @return TrainingSetToSchedule
     */
    public function setTrainingSetId(int $trainingSetId): TrainingSetToSchedule
    {
        $this->trainingSetId = $trainingSetId;
        return $this;
    }

    /**
     * @return TrainingSet|null
     */
    public function getTrainingSet(): ?TrainingSet
    {
        return $this->trainingSet;
    }

    /**
     * @param TrainingSet|null $trainingSet
     * @return TrainingSetToSchedule
     */
    public function setTrainingSet(?TrainingSet $trainingSet): TrainingSetToSchedule
    {
        $this->trainingSet = $trainingSet;
        return $this;
    }

    /**
     * @return int
     */
    public function getScheduleId(): int
    {
        return $this->scheduleId;
    }

    /**
     * @param int $scheduleId
     * @return TrainingSetToSchedule
     */
    public function setScheduleId(int $scheduleId): TrainingSetToSchedule
    {
        $this->scheduleId = $scheduleId;
        return $this;
    }
}
