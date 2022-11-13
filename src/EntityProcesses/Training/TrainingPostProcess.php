<?php

namespace App\EntityProcesses\Training;

use ApiPlatform\Metadata\Operation;
use App\Core\Api\EntityProcessAbstract;
use App\Core\Api\EntityProcessInterface;
use App\Core\Exceptions\StandardExceptions\EmptyValueException;
use App\Entity\Training;

class TrainingPostProcess extends EntityProcessAbstract implements EntityProcessInterface
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
        if(!$data->getName()) {
            throw new EmptyValueException(EmptyValueException::MESSAGE, EmptyValueException::CODE);
        }
        $data->setName(trim($data->getName()));
        if($data->getDescription()) {
            $data->setDescription(trim($data->getDescription()));
        }
    }

    /**
     * @param Training $data
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