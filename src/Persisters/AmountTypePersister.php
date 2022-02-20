<?php

namespace App\Persisters;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Core\Database\HelperEntity\SoftDelete;
use App\Entity\AmountType;
use App\Entity\Ingredient;
use App\Persisters\Core\DataPersisterExtension;

class AmountTypePersister extends DataPersisterExtension implements ContextAwareDataPersisterInterface
{
    /**
     * @inheritDoc
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof AmountType;
    }

    /**
     * @inheritDoc
     */
    public function persist($data, array $context = []): object
    {
        return parent::persist($data, $context);
    }

    /**
     * @inheritDoc
     */
    public function remove($data, array $context = []): void
    {
        parent::remove($data, $context);
    }

    public function prePersist($data, $context = []): void
    {

    }

    /**
     * @param $data AmountType
     * @param $context
     * @return void
     */
    public function overridePersist($data, $context = []): void
    {
        $this->dbPersist($data);
        $this->dbFlush();
    }

    /**
     * @param $data Ingredient
     * @param $context
     * @return void
     */
    public function postPersist($data, $context = []): void
    {
    }

    public function preUpdate($data, $context = []): void
    {

    }

    public function update($data, $context = []): void
    {
        $this->dbFlush();
    }

    /**
     * @param $data Ingredient
     * @param $context
     * @return void
     */
    public function postUpdate($data, $context = []): void
    {
    }

    public function preRemove($data, $context = []): void
    {
        $this->handleAmountTypeDeleteOnIngredient($data);
    }

    /**
     * @param $data Ingredient
     * @param $context
     * @return void
     */
    public function overrideRemove($data, $context = []): void
    {
        $this->dbRemove($data);
        $this->dbFlush();
    }

    public function postRemove($data, $context = []): void
    {
    }

    private function handleAmountTypeDeleteOnIngredient(AmountType $data): void
    {
        $now = new \DateTime();

        $ingredientsAssignedToGivenAmountType = $this->getIngredientRepository()->getIngredientsByAmountType($data);

        foreach ($ingredientsAssignedToGivenAmountType as $ingredient) {
            if ($ingredient instanceof SoftDelete) {
                $ingredient->setDeleted(true);
                $ingredient->setDeletedAt($now);
            }
        }

        $this->dbFlush();
    }

}