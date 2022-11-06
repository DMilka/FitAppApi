<?php

namespace App\Persisters;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Core\Exceptions\StandardExceptions\ItemNotFoundException;
use App\Core\Exceptions\StandardExceptions\WrongValueException;
use App\Core\HandlerAbstract;
use App\Core\Helpers\ClassCastHelper;
use App\Core\Helpers\EntityConnectorCreatorCheck\EntityConnectorCreatorCheckEvent;
use App\Core\Helpers\EntityConnectorCreatorCheck\EntityConnectorCreatorCheckSubscriber;
use App\Entity\Ingredient;
use App\Entity\IngredientToMeal;
use App\Entity\Meal;
use App\Entity\MealSet;
use App\Entity\MealToMealSet;

class MealSetPersister extends HandlerAbstract implements ProcessorInterface
{
    /**
     * @inheritDoc
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof MealSet;
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        // TODO: Implement process() method.
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
        $this->checkIfUserHasHisOwnMeals($data);
    }

    /**
     * @param $data MealSet
     * @param $context
     * @return void
     */
    public function overridePersist($data, $context = []): void
    {
        $this->dbPersist($data);
        $this->dbFlush();
    }

    /**
     * @param $data MealSet
     * @param $context
     * @return void
     */
    public function postPersist($data, $context = []): void
    {
        $entityConnectorEvent = new EntityConnectorCreatorCheckEvent($data, [MealToMealSet::class]);

        $this->getEventDispatcher()->dispatch($entityConnectorEvent);

        /** @var MealToMealSet[] $createdElements */
        $createdElements = $entityConnectorEvent->getCreatedElements();

        $this->createIngredientsOrMealToMealSet($data, $createdElements);

        $this->dbFlush();
    }

    public function preUpdate($data, $context = []): void
    {
        $this->checkIfUserHasHisOwnMeals($data);
    }

    public function update($data, $context = []): void
    {
        $this->dbFlush();
    }

    /**
     * @param $data MealSet
     * @param $context
     * @return void
     */
    public function postUpdate($data, $context = []): void
    {
        $entityConnectorEvent = new EntityConnectorCreatorCheckEvent($data, [MealToMealSet::class]);

        $this->getEventDispatcher()->dispatch($entityConnectorEvent);

        /** @var MealToMealSet[] $createdElements */
        $createdElements = $entityConnectorEvent->getCreatedElements();
        $ingredientId = [];
        $mealId = [];
        foreach ($createdElements as $element) {
            if ($element->{EntityConnectorCreatorCheckSubscriber::CLASS_NAME} === "MealToMealSet") {
                /** @var MealToMealSet $mealToMealSet */
                foreach ($element->{EntityConnectorCreatorCheckSubscriber::ELEMENTS} as $mealToMealSet) {
                    if ($mealToMealSet->getIngredientId()) {
                        $ingredientId[] = $mealToMealSet->getIngredientId();
                    }

                    if ($mealToMealSet->getMealId()) {
                        $mealId[] = $mealToMealSet->getMealId();
                    }
                }

                /** @var IngredientToMeal[] $toDelete */
                $toDeleteIngredient = $this->getMealToMealSetRepository()->getElementsToDeleteByIngredientArrAndMealSetId($data, $ingredientId);
                $toDeleteMeals = $this->getMealToMealSetRepository()->getElementsToDeleteByMealArrAndMealSetId($data, $mealId);

                $now = new \DateTime('now', new \DateTimeZone('Europe/Warsaw'));
                foreach (array_merge($toDeleteIngredient, $toDeleteMeals) as $item) {
                    $item->setDeleted(true);
                    $item->setDeletedAt($now);
                }
            }
        }

        $this->createIngredientsOrMealToMealSet($data, $createdElements);

        $this->dbFlush();
    }

    public function preRemove($data, $context = []): void
    {
    }

    /**
     * @param $data MealSet
     * @param $context
     * @return void
     */
    public function overrideRemove($data, $context = []): void
    {
        /** @var MealToMealSet[] $mealToMealSet */
        $mealToMealSet = $this->getMealToMealSetRepository()->getAllMealToMealSetByMealSet($data);

        $now = new \DateTime();
        foreach ($mealToMealSet as $item) {
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

    private function checkIfUserHasHisOwnMeals(MealSet $data): void
    {

    }

    /**
     * @param MealSet $data
     * @param MealToMealSet[] $createdElements
     * @return void
     */
    private function createIngredientsOrMealToMealSet(MealSet $data, array $createdElements): void
    {
        if (count($createdElements) > 0) {
            $userId = $this->getUserHelper()->getUser()->getId();
            foreach ($createdElements as $element) {
                if ($element->{EntityConnectorCreatorCheckSubscriber::CLASS_NAME} === "MealToMealSet") {
                    /** @var MealToMealSet $mealToMealSet */
                    foreach ($element->{EntityConnectorCreatorCheckSubscriber::ELEMENTS} as $mealToMealSet) {
                        if ($mealToMealSet->getIngredientId() !== null) {
                            /** @var Ingredient $ingredient */
                            $ingredient = $this->getIngredientRepository()->find($mealToMealSet->getIngredientId());

                            if ($ingredient) {
                                if ($ingredient->getUserId() === $userId) {
                                    $mealToMealSet->setIngredient($ingredient);
                                    $mealToMealSet->setMealSetId($data->getId());

                                    if ($mealToMealSet->getId()) {
                                        $existingMealToMealSetl = $this->getMealToMealSetRepository()->find($mealToMealSet->getId());

                                        if ($existingMealToMealSetl) {
                                            ClassCastHelper::updateObject($existingMealToMealSetl, $mealToMealSet, $this->getManager());
                                        }
                                    } else {
                                        $this->dbPersist($mealToMealSet);
                                    }
                                } else {
                                    throw new WrongValueException(WrongValueException::MESSAGE);
                                }
                            } else {
                                throw new ItemNotFoundException(ItemNotFoundException::MESSAGE);
                            }
                        }

                        if ($mealToMealSet->getMealId() !== null) {
                            /** @var Meal $meal */
                            $meal = $this->getMealRepository()->find($mealToMealSet->getMealId());

                            if ($meal) {
                                if ($meal->getUserId() === $userId) {
                                    $mealToMealSet->setMeal($meal);
                                    $mealToMealSet->setMealSetId($data->getId());

                                    if ($mealToMealSet->getId()) {
                                        $existingMealToMealSetl = $this->getMealToMealSetRepository()->find($mealToMealSet->getId());

                                        if ($existingMealToMealSetl) {
                                            ClassCastHelper::updateObject($existingMealToMealSetl, $mealToMealSet, $this->getManager());
                                        }
                                    } else {
                                        $this->dbPersist($mealToMealSet);
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
}