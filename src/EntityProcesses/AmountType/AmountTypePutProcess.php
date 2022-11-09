<?php

namespace App\EntityProcesses\AmountType;

use ApiPlatform\Metadata\Operation;
use App\Core\Api\EntityProcessAbstract;
use App\Core\Api\EntityProcessInterface;
use App\Core\Exceptions\StandardExceptions\EmptyValueException;
use App\Core\Exceptions\StandardExceptions\EntityProcessException;
use App\Entity\AmountType;

class AmountTypePutProcess extends EntityProcessAbstract implements EntityProcessInterface
{
    /**
     * @param AmountType $data
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
     * @param AmountType $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return void
     */
    public function executeProcess(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        try {
            $this->getManager()->beginTransaction();
            $this->getManager()->flush();
            $this->getManager()->commit();
        } catch (\Exception $exception) {
            $this->logCritical($exception->getMessage(), __METHOD__);
            $this->getManager()->rollback();
            throw new EntityProcessException(EntityProcessException::MESSAGE, EntityProcessException::CODE);
        }
    }
}