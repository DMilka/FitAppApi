<?php

namespace App\EntityProcesses\TrainingSet;

use ApiPlatform\Metadata\Operation;
use App\Core\Api\EntityProcessAbstract;
use App\Core\Api\EntityProcessInterface;
use App\Core\Exceptions\StandardExceptions\EmptyValueException;
use App\Entity\TrainingSet;

class TrainingSetPutProcess extends EntityProcessAbstract implements EntityProcessInterface
{
    /**
     * @param TrainingSet $data
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
     * @param TrainingSet $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return void
     */
    public function executeProcess(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        parent::executeProcess($data, $operation, $uriVariables, $context);
    }

    /**
     * @param TrainingSet $data
     * @return void
     */
    protected function validateName(TrainingSet $data): void
    {
        if(!$data->getName()) {
            throw new EmptyValueException(EmptyValueException::MESSAGE, EmptyValueException::CODE);
        }
        $data->setName(trim($data->getName()));
    }

    /**
     * @param TrainingSet $data
     * @return void
     */
    protected function validateDescription(TrainingSet $data): void
    {
        if($data->getDescription()) {
            $data->setDescription(trim($data->getDescription()));
        }
    }
}