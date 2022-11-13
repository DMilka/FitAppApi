<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Core\Database\HelperEntity\SoftDelete;
use App\EntityProcesses\TrainingToTrainingSet\TrainingToTrainingSetDeleteProcess;
use App\EntityProcesses\TrainingToTrainingSet\TrainingToTrainingSetPostProcess;
use App\EntityProcesses\TrainingToTrainingSet\TrainingToTrainingSetPutProcess;
use App\Repository\TrainingToTrainingSetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(
    repositoryClass: TrainingToTrainingSetRepository::class
)]
#[ApiResource]
#[Get(
    security: "is_granted('ROLE_TRAINING_TO_TRAINING_SET_GET')",
)]
#[GetCollection(
    security: "is_granted('ROLE_TRAINING_TO_TRAINING_SET_GET')",
)]
#[Post(
    security: "is_granted('ROLE_TRAINING_TO_TRAINING_SET_POST')",
    processor: TrainingToTrainingSetPostProcess::class
)]
#[Put(
    security: "is_granted('ROLE_TRAINING_TO_TRAINING_SET_PUT')",
    processor: TrainingToTrainingSetPutProcess::class
)]
#[Delete(
    security: "is_granted('ROLE_TRAINING_TO_TRAINING_SET_DELETE', object)",
    processor: TrainingToTrainingSetDeleteProcess::class
)]
class TrainingToTrainingSet extends SoftDelete
{
    #[Orm\Id, ORM\Column(name: 'id', type:'integer'), ORM\GeneratedValue]
    private ?int $id = null;

    #[Orm\Column(name:'training_id',type: 'integer')]
    private int $trainingId;

    #[ORM\OneToOne(targetEntity: Training::class, cascade: ['persist'])]
    private ?Training $training = null;

    #[Orm\Column(name:'training_set_id', type: 'integer')]
    private int $trainingSetId;

    #[Orm\Column(name:'amount', type: 'integer', nullable: true)]
    private ?int $amount = null;

    #[Orm\Column(name:'series_amount', type: 'integer', nullable: true)]
    private ?int $seriesAmount = null;

    #[Orm\Column(name:'time', type: 'integer', nullable: true)]
    private ?int $time = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getTrainingId(): int
    {
        return $this->trainingId;
    }

    /**
     * @param int $trainingId
     * @return TrainingToTrainingSet
     */
    public function setTrainingId(int $trainingId): TrainingToTrainingSet
    {
        $this->trainingId = $trainingId;
        return $this;
    }

    /**
     * @return Training|null
     */
    public function getTraining(): ?Training
    {
        return $this->training;
    }

    /**
     * @param Training|null $training
     * @return TrainingToTrainingSet
     */
    public function setTraining(?Training $training): TrainingToTrainingSet
    {
        $this->training = $training;
        return $this;
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
     * @return TrainingToTrainingSet
     */
    public function setTrainingSetId(int $trainingSetId): TrainingToTrainingSet
    {
        $this->trainingSetId = $trainingSetId;
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
     * @return TrainingToTrainingSet
     */
    public function setAmount(?int $amount): TrainingToTrainingSet
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSeriesAmount(): ?int
    {
        return $this->seriesAmount;
    }

    /**
     * @param int|null $seriesAmount
     * @return TrainingToTrainingSet
     */
    public function setSeriesAmount(?int $seriesAmount): TrainingToTrainingSet
    {
        $this->seriesAmount = $seriesAmount;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getTime(): ?int
    {
        return $this->time;
    }

    /**
     * @param int|null $time
     * @return TrainingToTrainingSet
     */
    public function setTime(?int $time): TrainingToTrainingSet
    {
        $this->time = $time;
        return $this;
    }

}
