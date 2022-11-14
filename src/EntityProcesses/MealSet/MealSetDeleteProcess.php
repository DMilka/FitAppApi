<?php

namespace App\EntityProcesses\MealSet;

use ApiPlatform\Metadata\Operation;
use App\Core\Api\EntityProcessAbstract;
use App\Core\Api\EntityProcessInterface;
use App\Core\Helpers\DateHelper;
use App\Entity\MealSet;

class MealSetDeleteProcess extends EntityProcessAbstract implements EntityProcessInterface
{
    /**
     * @param MealSet $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return void
     */
    public function executePreProcess(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $data->setDeleted(true);
        $data->setDeletedAt(DateHelper::getActualDate());
    }
}