<?php

namespace App\EntityProcesses\TrainingToTrainingSet;

use ApiPlatform\Metadata\Operation;
use App\Core\Api\EntityProcessAbstract;
use App\Core\Api\EntityProcessInterface;
use App\Core\Exceptions\StandardExceptions\ItemNotFoundException;
use App\Core\Exceptions\StandardExceptions\WrongOwnerException;
use App\Entity\Training;
use App\Entity\TrainingSet;
use App\Entity\TrainingToTrainingSet;

class TrainingToTrainingSetPutProcess extends EntityProcessAbstract implements EntityProcessInterface
{
    /**
     * @param TrainingToTrainingSet $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return void
     */
    public function executePreProcess(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $userId = $this->getUserId();
        $training = $data->getTraining();
        if(!$training) {
            $trainingId = $data->getTrainingId();

            /** @var Training $training */
            $training = $this->getTrainingRepository()->find($trainingId);
            if(!$training) {
                throw new ItemNotFoundException(ItemNotFoundException::TRAINING_NOT_FOUND_MESSAGE, ItemNotFoundException::CODE);
            }

            $data->setTraining($training);
        }

        if($training->getUserId() !== $userId) {
            throw new WrongOwnerException(WrongOwnerException::MESSAGE, WrongOwnerException::CODE);
        }

        $trainingSetId = $data->getTrainingSetId();
        if($trainingSetId) {
            /**
             * @var TrainingSet $trainingSet
             */
            $trainingSet = $this->getTrainingSetRepository()->find($trainingSetId);

            if($userId !== $trainingSet->getUserId()) {
                throw new WrongOwnerException(WrongOwnerException::MESSAGE, WrongOwnerException::CODE);
            }
        }
    }

    /**
     * @param TrainingToTrainingSet $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return void
     */
    public function executeProcess(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        parent::executeProcess($data, $operation, $uriVariables, $context);
    }

}