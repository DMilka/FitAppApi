<?php

namespace App\EntityProcesses\TrainingToTrainingSet;

use ApiPlatform\Metadata\Operation;
use App\Core\Api\EntityProcessAbstract;
use App\Core\Helpers\DateHelper;
use App\Entity\TrainingToTrainingSet;

class TrainingToTrainingSetDeleteProcess extends EntityProcessAbstract
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
        $data->setDeletedAt(DateHelper::getActualDate());
        $data->setDeleted(true);
    }
}