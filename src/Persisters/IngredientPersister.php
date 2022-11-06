<?php

namespace App\Persisters;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Core\Exceptions\StandardExceptions\ItemNotFoundException;
use App\Core\HandlerAbstract;
use App\Entity\AmountType;
use App\Entity\Ingredient;
use App\Entity\IngredientToMeal;
use App\Persisters\Core\DataPersisterExtension;

class IngredientPersister extends HandlerAbstract implements ProcessorInterface
{
    /**
     * @inheritDoc
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Ingredient;
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        // TODO: Implement process() method.
    }

    /**
     * @inheritDoc
     */
    public function persist($data, array $context = []): object
    {
//        return parent::persist($data, $context);
    }

    /**
     * @inheritDoc
     */
    public function remove($data, array $context = []): void
    {
//        parent::remove($data, $context);
    }

    public function prePersist($data, $context = []): void
    {
        $this->checkIfUserPassedOwnAmountType($data);
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
        $this->checkIfUserPassedOwnAmountType($data);
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
        $this->handleIngredientDeleteOnIngredientToMeal($data);
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

    private function checkIfUserPassedOwnAmountType(Ingredient $data): void
    {
        $amountTypeId = $data->getAmountTypeId();

        /** @var AmountType $amountType */
        $amountType = $this->getAmountTypeRepository()->findNotDeleted($amountTypeId);

        $userId = $this->getUserHelper()->getUser()->getId();

        if (!$amountType || $amountType->getUserId() !== $userId) {
            throw new ItemNotFoundException(ItemNotFoundException::AMOUNT_TYPE_NOT_FOUND_MESSAGE);
        }
    }

    private function handleIngredientDeleteOnIngredientToMeal(Ingredient $data): void
    {
        /** @var IngredientToMeal[] $ingredientToMeals */
        $ingredientToMeals = $this->getIngredientToMealRepository()->getAllIngredientToMealByIngredient($data);

        $now = new \DateTime();

        foreach ($ingredientToMeals as $ingredientToMeal) {

            $ingredientToMeal->setDeleted(true);
            $ingredientToMeal->setDeletedAt($now);
        }

        $this->dbFlush();
    }

}