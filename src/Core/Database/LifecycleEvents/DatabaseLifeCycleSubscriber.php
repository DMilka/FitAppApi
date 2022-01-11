<?php

namespace App\Core\Database\LifecycleEvents;

use App\Core\Helpers\UserHelper;
use App\Entity\AmountType;
use App\Entity\Ingredient;
use App\Entity\Meal;
use App\Entity\MealSet;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class DatabaseLifeCycleSubscriber implements EventSubscriberInterface
{
    private UserHelper $userHelper;
    const FILL_WITH_USER_ID = [
        AmountType::class,
        Ingredient::class,
        Meal::class,
        MealSet::class,
    ];


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

        $this->checkToFillWithUserId($object);
    }

    private function checkToFillWithUserId($object): void
    {
        if(in_array(get_class($object), self::FILL_WITH_USER_ID)) {
            $this->fillWithUserId($object);
        }
    }

    private function fillWithUserId($object): void
    {
        $user = $this->userHelper->getUser();
        $object->setUserId($user->getId());
    }
}