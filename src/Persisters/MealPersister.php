<?php

namespace App\Persisters;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Core\Authentication\Helper\FormHelper;
use App\Core\Exceptions\StandardExceptions\ItemNotFoundException;
use App\Core\Exceptions\StandardExceptions\WrongOwnerException;
use App\Core\Exceptions\StandardExceptions\WrongValueException;
use App\Core\Helpers\ArrayHelper;
use App\Core\Helpers\ClassCastHelper;
use App\Core\Helpers\EntityConnectorCreatorCheck\EntityConnectorCreatorCheckEvent;
use App\Core\Helpers\EntityConnectorCreatorCheck\EntityConnectorCreatorCheckSubscriber;
use App\Entity\Ingredient;
use App\Entity\IngredientToMeal;
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
     * @param $data Meal
     * @param $context
     * @return void
     */
    public function overridePersist($data, $context = []): void
    {
        FormHelper::checkNullValueWithException($data->getName());
        $this->dbPersist($data);
        $this->dbFlush();
    }

    /**
     * @param $data Meal
     * @param $context
     * @return void
     */
    public function postPersist($data, $context = []): void
    {
        $entityConnectorEvent = new EntityConnectorCreatorCheckEvent($data, [IngredientToMeal::class]);

        $this->getEventDispatcher()->dispatch($entityConnectorEvent);

        /** @var IngredientToMeal[] $createdElements */
        $createdElements = $entityConnectorEvent->getCreatedElements();

        $this->createIngredientsToMeal($data, $createdElements);

        $this->dbFlush();
    }

    /**
     * @param Meal $data
     * @param $context
     * @return void
     */
    public function preUpdate($data, $context = []): void
    {
        $entityConnectorEvent = new EntityConnectorCreatorCheckEvent($data, [IngredientToMeal::class]);

        $this->getEventDispatcher()->dispatch($entityConnectorEvent);

        /** @var IngredientToMeal[] $createdElements */
        $createdElements = $entityConnectorEvent->getCreatedElements();
        $createdElementsIngredientIds = [];

        foreach ($createdElements as $element) {
            if ($element->{EntityConnectorCreatorCheckSubscriber::CLASS_NAME} === "IngredientToMeal") {
                /** @var IngredientToMeal $ingredientToMeal */
                foreach ($element->{EntityConnectorCreatorCheckSubscriber::ELEMENTS} as $ingredientToMeal) {
                    $createdElementsIngredientIds[] = $ingredientToMeal->getIngredientId();
                }

                /** @var IngredientToMeal[] $toDelete */
                $toDeleteArr = $this->getIngredientToMealRepository()->getAllElementsToDelete($createdElementsIngredientIds, $data);

                $now = new \DateTime('now', new \DateTimeZone('Europe/Warsaw'));
                foreach ($toDeleteArr as $item) {
                    $item->setDeleted(true);
                    $item->setDeletedAt($now);
                }
            }
        }
        
        $this->createIngredientsToMeal($data, $createdElements);

        $this->dbFlush();
    }

    public function update($data, $context = []): void
    {
        FormHelper::checkNullValueWithException($data->getName());
        $this->dbFlush();
    }

    /**
     * @param $data Meal
     * @param $context
     * @return void
     */
    public function postUpdate($data, $context = []): void
    {
    }

    public function preRemove($data, $context = []): void
    {
    }

    /**
     * @param $data Meal
     * @param $context
     * @return void
     */
    public function overrideRemove($data, $context = []): void
    {
        /** @var IngredientToMeal[] $ingredientsToMeal */
        $ingredientsToMeal = $this->getIngredientToMealRepository()->getAllIngredientForGivenMeal($data);

        $now = new \DateTime();
        foreach ($ingredientsToMeal as $item) {
            $item->setDeleted(true);
            $item->setDeletedAt($now);
        }
        $this->dbFlush();
        $this->dbRemove($data);
        $this->dbFlush();
    }

    public function postRemove($data, $context = []): void
    {
    }

    private function getFreshlyCreatedElements(array $ingredientToMealArr): array
    {
        $freshlyCreated = [];
        foreach ($ingredientToMealArr as $ingredientToMeal) {
            if (!$ingredientToMeal->getId()) {
                $freshlyCreated[] = $ingredientToMeal;
            }
        }

        return $freshlyCreated;
    }

    private function createIngredientsToMeal(Meal $data, array $createdElements): void
    {
        if (count($createdElements) > 0) {
            $userId = $this->getUserHelper()->getUser()->getId();
            foreach ($createdElements as $element) {
                if ($element->{EntityConnectorCreatorCheckSubscriber::CLASS_NAME} === "IngredientToMeal") {
                    /** @var IngredientToMeal $ingredientToMeal */
                    foreach ($element->{EntityConnectorCreatorCheckSubscriber::ELEMENTS} as $ingredientToMeal) {
                        /** @var Ingredient $ingredient */
                        $ingredient = $this->getIngredientRepository()->find($ingredientToMeal->getIngredientId());

                        if ($ingredient) {
                            if ($ingredient->getUserId() === $userId) {
                                $ingredientToMeal->setIngredient($ingredient);
                                $ingredientToMeal->setMealId($data->getId());

                                if ($ingredientToMeal->getId()) {
                                    $existingIngredientToMeal = $this->getIngredientToMealRepository()->find($ingredientToMeal->getId());

                                    if ($existingIngredientToMeal) {
                                        ClassCastHelper::updateObject($existingIngredientToMeal, $ingredientToMeal, $this->getManager());
                                    }
                                } else {
                                    $this->dbPersist($ingredientToMeal);
                                }
                            } else {
                                throw new WrongValueException(WrongValueException::MESSAGE);
                            }
                        } else {
                            throw new ItemNotFoundException(ItemNotFoundException::MESSAGE);
                        }
                    }
                }
            }
        }
    }

}