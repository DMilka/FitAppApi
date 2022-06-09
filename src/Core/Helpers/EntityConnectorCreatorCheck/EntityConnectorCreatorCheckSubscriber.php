<?php

namespace App\Core\Helpers\EntityConnectorCreatorCheck;

use App\Core\Database\EntityTraits\EntityConnectorCreatorTrait;
use App\Core\Exceptions\EntityConnectorCreatorCheckExceptions\EmptyParentClassNameException;
use App\Core\Exceptions\EntityConnectorCreatorCheckExceptions\NoEntityConnectorElementsException;
use App\Core\Exceptions\EntityConnectorCreatorCheckExceptions\ParentClassNotExistException;
use App\Core\HandlerAbstract;
use Doctrine\ORM\EntityNotFoundException;
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

        $elements = $entityConnectorCreatorCheckEvent->getDecodedElementsEntity();

        if ($elements) {
            $entityConnectorCreatorCheckEvent->setDecodedElementsEntity(json_decode($elements));
        } else {

            throw new NoEntityConnectorElementsException(NoEntityConnectorElementsException::MESSAGE, NoEntityConnectorElementsException::CODE);
        }


    }

    public function createElementsAndSaveToDb(EntityConnectorCreatorCheckEvent $entityConnectorCreatorCheckEvent): void
    {
        if (!$entityConnectorCreatorCheckEvent->isEntitySupportTrait()) {
            return;
        }


    }
}