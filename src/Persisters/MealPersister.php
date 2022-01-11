<?php

namespace App\Persisters;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Meal;
use App\Persisters\Core\DataPersisterExtension;

class MealPersister extends DataPersisterExtension implements ContextAwareDataPersisterInterface
{
    /**
     * @inheritDoc
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Meal;
    }

    /**
     * @inheritDoc
     */
    public function persist($data, array $context = []): void
    {
        parent::persist($data,$context);
    }

    /**
     * @inheritDoc
     */
    public function remove($data, array $context = []):void
    {
        parent::remove($data,$context);
    }

    public function prePersist($data, $context = []): void
    {
        // TODO: Implement prePersist() method.
    }

    public function overridePersist($data, $context = []): void
    {
        // TODO: Implement overridePersist() method.
    }

    public function postPersist($data, $context = []): void
    {
        // TODO: Implement postPersist() method.
    }

    public function preUpdate($data, $context = []): void
    {
        // TODO: Implement preUpdate() method.
    }

    public function update($data, $context = []): void
    {
        // TODO: Implement update() method.
    }

    public function postUpdate($data, $context = []): void
    {
        // TODO: Implement postUpdate() method.
    }

    public function preRemove($data, $context = []): void
    {
        // TODO: Implement preRemove() method.
    }

    public function overrideRemove($data, $context = []): void
    {
        // TODO: Implement overrideRemove() method.
    }

    public function postRemove($data, $context = []): void
    {
        // TODO: Implement postRemove() method.
    }

}