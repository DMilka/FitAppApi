<?php

namespace App\Core\Database\LifecycleEvents;

use App\Core\Database\HelperEntity\SoftDelete;
use App\Core\Database\HelperEntity\UserExtension;
use App\Core\Helpers\UserHelper;
use App\Entity\Ingredient;
use App\Entity\IngredientToMeal;
use App\Entity\MealSet;
use App\Entity\MealToMealSet;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;
use EasyRdf\Literal\Date;

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
            Events::prePersist,
            Events::onFlush
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $object = $args->getObject();

        $this->checkToFillWithUserId($object);
    }

    public function onFlush(OnFlushEventArgs $args): void
    {
        $em = $args->getEntityManager();
        $uow = $em->getUnitOfWork();

        $toDeletes = $uow->getScheduledEntityDeletions();
        foreach ($toDeletes as $toDelete) {
            if ($toDelete instanceof SoftDelete) {
                $em->clear();

                $className = $em->getClassMetadata(get_class($toDelete))->getName();

                /** @var SoftDelete $upd */
                $deleteItem = $em->find($className, $toDelete->getId());
                $deleteItem->setDeleted(true);
                $deleteItem->setDeletedAt(new \DateTime());
                $em->flush();
            }

            if ($toDelete instanceof Ingredient) {
                /** @var IngredientToMeal[] $ingredientToMeals */
                $ingredientToMeals = $em->getRepository(IngredientToMeal::class)->getAllIngredientToMealByIngredient($toDelete->getId());

                $now = new \DateTime();
                foreach ($ingredientToMeals as $ingredientToMeal) {
                    $ingredientToMeal->setDeleted(true);
                    $ingredientToMeal->setDeletedAt($now);
                }

                $em->flush();
            }
        }

    }

    private function checkToFillWithUserId($object): void
    {
        if ($object instanceof UserExtension) {
            $this->fillWithUserId($object);
        }
    }

    private function fillWithUserId($object): void
    {
        $user = $this->userHelper->getUser();
        $object->setUserId($user->getId());
    }
}