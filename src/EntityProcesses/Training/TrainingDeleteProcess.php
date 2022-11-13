<?php

namespace App\EntityProcesses\Training;

use ApiPlatform\Metadata\Operation;
use App\Core\Api\EntityProcessAbstract;
use App\Core\Helpers\DateHelper;
use App\Entity\Training;

class TrainingDeleteProcess extends EntityProcessAbstract
{
    /**
     * @param Training $data
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