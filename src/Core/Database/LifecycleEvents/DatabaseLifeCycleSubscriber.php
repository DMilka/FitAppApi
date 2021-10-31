<?php

namespace App\Core\Database\LifecycleEvents;

use App\Core\Helpers\UserHelper;
use App\Entity\AmountType;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class DatabaseLifeCycleSubscriber implements EventSubscriberInterface
{
    private UserHelper $userHelper;

    public function __construct(UserHelper $userHelper)
    {
        $this->userHelper = $userHelper;
    }

    /**
     * @inheritDoc
     */
    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {

        $object = $args->getObject();

        if($object instanceof AmountType) {
            /** @var Users $user */
            $user = $this->userHelper->getUser();

            $object->setUserId($user->getId());
        }

        $tmp = 1;
    }
}