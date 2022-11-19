<?php

namespace App\EntityProcesses\TrainingSetToSchedule;

use ApiPlatform\Metadata\Operation;
use App\Core\Api\EntityProcessAbstract;
use App\Core\Api\EntityProcessInterface;
use App\Core\Exceptions\StandardExceptions\EntityProcessException;
use App\Core\Exceptions\StandardExceptions\ItemNotFoundException;
use App\Core\Exceptions\StandardExceptions\WrongOwnerException;
use App\Core\Exceptions\StandardExceptions\WrongValueException;
use App\Entity\MealSet;
use App\Entity\MealSetToSchedule;
use App\Entity\Schedule;
use App\Entity\Training;
use App\Entity\TrainingSet;
use App\Entity\TrainingSetToSchedule;

class TrainingSetToSchedulePutProcess extends EntityProcessAbstract implements EntityProcessInterface
{
    /**
     * @param TrainingSetToSchedule $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return void
     */
    public function executePreProcess(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $userId = $this->getUserId();

        // Check mealSet
        $trainingSetId = $data->getTrainingSetId();
        if(!$trainingSetId) {
            throw new WrongValueException(WrongValueException::MESSAGE, WrongValueException::CODE);
        }

        try {
            /**
             * @var TrainingSet $trainingSet
             */
            $trainingSet = $this->getTrainingSetRepository()->findNotDeleted($trainingSetId);
        } catch (\Exception $exception) {
            $this->logCritical($exception->getMessage(),__METHOD__);
            throw new EntityProcessException(EntityProcessException::MESSAGE, EntityProcessException::CODE);
        }

        if(!$trainingSet) {
            throw new ItemNotFoundException(ItemNotFoundException::TRAINING_SET_NOT_FOUND_MESSAGE, ItemNotFoundException::CODE);
        }

        if($trainingSet->getUserId() !== $userId) {
            throw new WrongOwnerException(WrongOwnerException::MESSAGE, WrongOwnerException::CODE);
        }

        $data->setTrainingSet($trainingSet);

        // Check schedule

        $scheduleId = $data->getScheduleId();

        if(!$scheduleId) {
            throw new WrongValueException(WrongValueException::MESSAGE, WrongValueException::CODE);
        }

        try {
            /**
             * @var Schedule $schedule
             */
            $schedule = $this->getScheduleRepository()->findNotDeleted($scheduleId);
        } catch (\Exception $exception) {
            $this->logCritical($exception->getMessage(), __METHOD__);
            throw new EntityProcessException(EntityProcessException::MESSAGE, EntityProcessException::CODE);
        }

        if(!$schedule) {
            throw new ItemNotFoundException(ItemNotFoundException::SCHEDULE_NOT_FOUND_MESSAGE, ItemNotFoundException::CODE);
        }

        if($schedule->getUserId() !== $userId) {
            throw new WrongValueException(WrongValueException::MESSAGE, WrongValueException::CODE);
        }
    }

}