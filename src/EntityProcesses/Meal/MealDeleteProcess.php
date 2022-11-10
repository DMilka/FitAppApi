<?php

namespace App\EntityProcesses\Meal;

use ApiPlatform\Metadata\Operation;
use App\Core\Api\EntityProcessAbstract;
use App\Core\Exceptions\StandardExceptions\EntityProcessException;
use App\Core\Helpers\DateHelper;
use App\Entity\Meal;

class MealDeleteProcess extends EntityProcessAbstract
{
    /**
     * @param Meal $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return void
     */
    public function executeProcess(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        try {
            $this->getManager()->beginTransaction();

            $data->setDeleted(true);
            $data->setDeletedAt(DateHelper::getActualDate());

            $this->getManager()->flush();
            $this->getManager()->commit();
        } catch (\Exception $exception) {
            $this->logCritical($exception->getMessage(), __METHOD__);
            $this->getManager()->rollback();
            throw new EntityProcessException(EntityProcessException::MESSAGE, EntityProcessException::CODE);
        }
    }
}