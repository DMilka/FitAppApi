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
    public const CLASS_NAME = 'className';
    public const ELEMENTS = 'elements';

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

        if (!$entityConnectorCreatorCheckEvent->getConnectorClassNameArr()) {
            throw new InvalidElementValueException(InvalidElementValueException::MESSAGE, InvalidElementValueException::CODE);
        }


        /** @var EntityConnectorCreatorTrait $parentEntity */
        $parentEntity = $entityConnectorCreatorCheckEvent->getParentEntity();

        if (!$parentEntity->getConnectorItems()) {
            throw new NoEntityConnectorElementsException(NoEntityConnectorElementsException::MESSAGE, NoEntityConnectorElementsException::CODE);
        } else {
            $parsedEntityElements = json_decode($parentEntity->getConnectorItems());

            if (!is_array($parsedEntityElements)) {
                throw new InvalidElementValueException(InvalidElementValueException::MESSAGE, InvalidElementValueException::CODE);
            } else {
                foreach ($parsedEntityElements as $parsedEntityElement) {
                    if (is_object($parsedEntityElement)) {
                        if (!property_exists($parsedEntityElement, self::CLASS_NAME)) {
                            throw new InvalidElementValueException(InvalidElementValueException::MESSAGE, InvalidElementValueException::CODE);
                        }
                        if (!property_exists($parsedEntityElement, self::ELEMENTS)) {
                            throw new InvalidElementValueException(InvalidElementValueException::MESSAGE, InvalidElementValueException::CODE);
                        }
                    } else {
                        throw new InvalidElementValueException(InvalidElementValueException::MESSAGE, InvalidElementValueException::CODE);
                    }
                }

                foreach ($entityConnectorCreatorCheckEvent->getConnectorClassNameArr() as $names) {
                    $parsedNames = explode("\\", $names);
                    $parsedName = $parsedNames[count($parsedNames) - 1];

                    $isOk = false;
                    foreach ($parsedEntityElements as $element) {
                        if ($element->{self::CLASS_NAME} === $parsedName) {
                            $isOk = true;
                        }
                    }

                    if (!$isOk) {
                        throw new InvalidElementValueException(InvalidElementValueException::MESSAGE, InvalidElementValueException::CODE);
                    }
                }
                $entityConnectorCreatorCheckEvent->setConnectorClassElements($parsedEntityElements);
            }
        }
    }

    public function createElementsAndSaveToDb(EntityConnectorCreatorCheckEvent $entityConnectorCreatorCheckEvent): void
    {
        if (!$entityConnectorCreatorCheckEvent->isEntitySupportTrait()) {
            return;
        }

        if ($entityConnectorCreatorCheckEvent->getConnectorClassNameArr() && count($entityConnectorCreatorCheckEvent->getConnectorClassElements()) > 0) {
            $items = $entityConnectorCreatorCheckEvent->getConnectorClassElements();

            foreach ($items as $item) {
                $className = $item->{self::CLASS_NAME};
                $elements = $item->{self::ELEMENTS};

                $createdElements = [];
                foreach ($entityConnectorCreatorCheckEvent->getConnectorClassNameArr() as $name) {
                    $parsedNames = explode('\\', $name);
                    $parsedName = $parsedNames[count($parsedNames) - 1];

                    if ($parsedName === $className) {
                        foreach ($elements as $element) {
                            if (is_object($element)) {
                                $entity = ClassCastHelper::cast($name, $element);

                                $createdElements[] = $entity;
                            }
                        }
                    }
                    break;
                }

                $alreadyCreated = $entityConnectorCreatorCheckEvent->getCreatedElements();
                $object = new \stdClass();

                $object->{self::CLASS_NAME} = $item->{self::CLASS_NAME};
                $object->{self::ELEMENTS} = $createdElements;

                $alreadyCreated[] = $object;
                $entityConnectorCreatorCheckEvent->setCreatedElements($alreadyCreated);
            }
        }
    }
}