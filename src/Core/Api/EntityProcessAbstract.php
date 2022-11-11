<?php

namespace App\Core\Api;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Core\Database\HelperEntity\UserExtension;
use App\Core\Exceptions\StandardExceptions\EntityProcessException;
use App\Core\Exceptions\StandardExceptions\WrongOwnerException;
use App\Core\HandlerAbstract;
use App\Core\Helpers\DateHelper;

class EntityProcessAbstract extends HandlerAbstract implements ProcessorInterface
{
    const POST_METHOD = 'POST';
    const PUT_METHOD = 'PUT';
    const DELETE_METHOD = 'DELETE';

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        try {
            $this->getManager()->beginTransaction();

            $this->checkUserExtensionOnEntity($data, $operation, $uriVariables, $context);
            $this->executePreProcess($data, $operation, $uriVariables, $context);

            $this->executeProcess($data, $operation, $uriVariables, $context);

            $this->executePostProcess($data, $operation, $uriVariables, $context);

        } catch (\Exception $exception) {
            $this->logCritical($exception->getMessage(), __METHOD__);
            $this->getManager()->rollback();
            throw new EntityProcessException(EntityProcessException::MESSAGE, EntityProcessException::CODE);
        }

        return $data;
    }

    public function executePreProcess(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $now = DateHelper::getActualDateString();
        $this->logDebug(sprintf('[%s] Executed preProcess', $now),__METHOD__);
    }
    public function executeProcess(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $now = DateHelper::getActualDateString();
        $this->logDebug(sprintf('[%s] Executed process', $now),__METHOD__);
        $this->getManager()->persist($data);
        $this->getManager()->flush();
        $this->getManager()->commit();
    }
    public function executePostProcess(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $now = DateHelper::getActualDateString();
        $this->logDebug(sprintf('[%s] Executed postProcess', $now),__METHOD__);
    }

    protected function checkUserExtensionOnEntity(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        if($data instanceof UserExtension) {
            if($operation->getMethod() === self::POST_METHOD) {
                $userId = $this->getUserId();
                $data->setUserId($userId);
                return;
            }

            if($operation->getMethod() === self::PUT_METHOD || $operation->getMethod() === self::DELETE_METHOD) {
                $userId = $this->getUserId();
                if($data->getUserId() !== $userId) {
                    throw new WrongOwnerException(WrongOwnerException::MESSAGE, WrongOwnerException::CODE);
                }
            }
        }
    }
}