<?php

namespace App\EntityProcesses\MealSetToSchedule;

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

class MealSetToSchedulePostProcess extends EntityProcessAbstract implements EntityProcessInterface
{
    /**
     * @param MealSetToSchedule $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return void
     */
    public function executePreProcess(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $userId = $this->getUserId();

        // Check mealSet
        $mealSetId = $data->getMealSetId();
        if(!$mealSetId) {
            throw new WrongValueException(WrongValueException::MESSAGE, WrongValueException::CODE);
        }

        try {
            /**
             * @var MealSet $mealSet
             */
            $mealSet = $this->getMealSetRepository()->findNotDeleted($mealSetId);
        } catch (\Exception $exception) {
            $this->logCritical($exception->getMessage(),__METHOD__);
            throw new EntityProcessException(EntityProcessException::MESSAGE, EntityProcessException::CODE);
        }

        if(!$mealSet) {
            throw new ItemNotFoundException(ItemNotFoundException::MEAL_SET_NOT_FOUND_MESSAGE, ItemNotFoundException::CODE);
        }

        if($mealSet->getUserId() !== $userId) {
            throw new WrongOwnerException(WrongOwnerException::MESSAGE, WrongOwnerException::CODE);
        }

        $data->setMealSet($mealSet);

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