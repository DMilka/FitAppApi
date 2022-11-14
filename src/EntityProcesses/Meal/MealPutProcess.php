<?php

namespace App\EntityProcesses\Meal;

use ApiPlatform\Metadata\Operation;
use App\Core\Api\EntityProcessAbstract;
use App\Core\Api\EntityProcessInterface;
use App\Core\Exceptions\StandardExceptions\EmptyValueException;
use App\Entity\Meal;

class MealPutProcess extends EntityProcessAbstract implements EntityProcessInterface
{
    /**
     * @param Meal $data
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
     * @param Meal $data
     * @return void
     */
    protected function validateName(Meal $data): void
    {
        if(!$data->getName()) {
            throw new EmptyValueException(EmptyValueException::MESSAGE, EmptyValueException::CODE);
        }
        $data->setName(trim($data->getName()));
    }

    /**
     * @param Meal $data
     * @return void
     */
    protected function validateDescription(Meal $data): void
    {
        if($data->getDescription()) {
            $data->setDescription(trim($data->getDescription()));
        }
    }
}