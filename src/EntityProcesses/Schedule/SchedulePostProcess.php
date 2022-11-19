<?php

namespace App\EntityProcesses\Schedule;

use ApiPlatform\Metadata\Operation;
use App\Core\Api\EntityProcessAbstract;
use App\Core\Api\EntityProcessInterface;
use App\Core\Exceptions\StandardExceptions\WrongValueException;
use App\Entity\Schedule;

class SchedulePostProcess extends EntityProcessAbstract implements EntityProcessInterface
{
    /**
     * @param Schedule $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return void
     */
    public function executePreProcess(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $plannedDate = $data->getPlannedAt();

        if(!$plannedDate instanceof \DateTime) {
            throw new WrongValueException(WrongValueException::MESSAGE, WrongValueException::CODE);
        }

        $userId = $this->getUserId();
        $data->setUserId($userId);
    }
}