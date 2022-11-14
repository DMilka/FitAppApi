<?php

namespace App\EntityProcesses\MealSet;

use ApiPlatform\Metadata\Operation;
use App\Core\Api\EntityProcessAbstract;
use App\Core\Api\EntityProcessInterface;
use App\Core\Exceptions\StandardExceptions\EmptyValueException;
use App\Entity\MealSet;

class MealSetPutProcess extends EntityProcessAbstract implements EntityProcessInterface
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
        $this->validateName($data);
        $this->validateDescription($data);
    }

    /**
     * @param MealSet $data
     * @return void
     */
    protected function validateName(MealSet $data): void
    {
        if(!$data->getName()) {
            throw new EmptyValueException(EmptyValueException::MESSAGE, EmptyValueException::CODE);
        }
        $data->setName(trim($data->getName()));
    }

    /**
     * @param MealSet $data
     * @return void
     */
    protected function validateDescription(MealSet $data): void
    {
        if($data->getDescription()) {
            $data->setDescription(trim($data->getDescription()));
        }
    }
}