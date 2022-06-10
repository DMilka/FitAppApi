<?php

namespace App\Core\Helpers\EntityConnectorCreatorCheck;

use App\Core\Database\EntityTraits\EntityConnectorCreatorTrait;
use App\Core\Exceptions\EntityConnectorCreatorCheckExceptions\InvalidElementValueException;
use App\Core\Exceptions\EntityConnectorCreatorCheckExceptions\NoEntityConnectorElementsException;
use App\Core\Exceptions\EntityConnectorCreatorCheckExceptions\NoEntityConnectorNameException;
use App\Core\HandlerAbstract;
use App\Core\Helpers\ClassCastHelper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EntityConnectorCreatorCheckSubscriber extends HandlerAbstract implements EventSubscriberInterface
{

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            EntityConnectorCreatorCheckEvent::class => [
                ['checkIfClassHasEntityConnectorCreatorCheckTrait', 100],
                ['checkValues', 90],
                ['createElementsAndSaveToDb', 80],
            ]
        ];
    }

    public function checkIfClassHasEntityConnectorCreatorCheckTrait(EntityConnectorCreatorCheckEvent $entityConnectorCreatorCheckEvent): void
    {
        $traits = class_uses($entityConnectorCreatorCheckEvent->getParentEntity());
        if (in_array(EntityConnectorCreatorTrait::class, $traits)) {
            $entityConnectorCreatorCheckEvent->setIsEntitySupportTrait(true);
        } else {
            $entityConnectorCreatorCheckEvent->setIsEntitySupportTrait(false);
        }
    }

    public function checkValues(EntityConnectorCreatorCheckEvent $entityConnectorCreatorCheckEvent): void
    {
        if (!$entityConnectorCreatorCheckEvent->isEntitySupportTrait()) {
            return;
        }

        /** @var EntityConnectorCreatorTrait $parentEntity */
        $parentEntity = $entityConnectorCreatorCheckEvent->getParentEntity();

        if (!$parentEntity->getEntityName()) {
            throw new NoEntityConnectorNameException(NoEntityConnectorNameException::MESSAGE, NoEntityConnectorNameException::CODE);
        } else {
            $entityConnectorCreatorCheckEvent->setChildEntityName($parentEntity->getEntityName());
        }

        if (!$parentEntity->getConnectorItems()) {
            throw new NoEntityConnectorElementsException(NoEntityConnectorElementsException::MESSAGE, NoEntityConnectorElementsException::CODE);
        } else {
            $parsedEntityElements = json_decode($parentEntity->getConnectorItems());
            if (!is_array($parsedEntityElements)) {
                throw new InvalidElementValueException(InvalidElementValueException::MESSAGE, InvalidElementValueException::CODE);
            } else {
                $entityConnectorCreatorCheckEvent->setChildEntityElements($parsedEntityElements);
            }
        }


    }

    public function createElementsAndSaveToDb(EntityConnectorCreatorCheckEvent $entityConnectorCreatorCheckEvent): void
    {
        if (!$entityConnectorCreatorCheckEvent->isEntitySupportTrait()) {
            return;
        }

        if ($entityConnectorCreatorCheckEvent->getChildEntityName() && count($entityConnectorCreatorCheckEvent->getChildEntityElements()) > 0) {
            try {
                foreach ($entityConnectorCreatorCheckEvent->getChildEntityElements() as $element) {
                    if (is_object($element)) {
                        $entityName = $entityConnectorCreatorCheckEvent->getChildEntityName();

                        $entity = ClassCastHelper::cast($entityName, $element);
                    }
                }
            } catch (\Exception $exception) {
                throw new $exception;
            }
        }
    }
}