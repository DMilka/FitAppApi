<?php

namespace App\Persisters;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Core\Authentication\Helper\FormHelper;
use App\Core\Exceptions\StandardExceptions\ItemNotFoundException;
use App\Core\Exceptions\StandardExceptions\WrongOwnerException;
use App\Core\Exceptions\StandardExceptions\WrongValueException;
use App\Core\Helpers\ArrayHelper;
use App\Entity\Ingredient;
use App\Entity\IngredientToMeal;
use App\Entity\Meal;
use App\Entity\MealSet;
use App\Entity\MealToMealSet;
use App\Persisters\Core\DataPersisterExtension;

class MealSetPersister extends DataPersisterExtension implements ContextAwareDataPersisterInterface
{
    /**
     * @inheritDoc
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof MealSet;
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
        $ids = $data->getMealIds();

        if ($ids) {
            $ids = json_decode($ids);
            if (is_array($ids)) {
                foreach ($ids as $id) {
                    $meal = $this->getMealRepository()->find($id);

                    if (!$meal) {
                        throw new ItemNotFoundException(ItemNotFoundException::MEAL_NOT_FOUND_MESSAGE);
                    }

                    $mealToMealSet = new MealToMealSet();
                    $mealToMealSet->setMeal($meal);
                    $mealToMealSet->setMealId($id);
                    $mealToMealSet->setMealSetId($data->getId());

                    $this->dbPersist($mealToMealSet);
                }

                $this->dbFlush();
            }
        }
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
        $oldElements = [];
        $newElements = [];
        $user = $this->getUserHelper()->getUser();

        // Get assigned elements
        /** @var MealToMealSet[] $assignedMeals */
        $assignedMeals = $this->getMealToMealSetRepository()->getAllMealsForMealSet($data);
        foreach ($assignedMeals as $mealSet) {
            $oldElements[] = $mealSet->getMealId();
        }
        // Get new elements
        $ids = $data->getMealIds();
        if ($ids) {
            $ids = json_decode($ids);
            if (is_array($ids)) {
                $newElements = $ids;
            }
        }

        // Elements to delete
        $toDelete = ArrayHelper::getOldElementsFromArrays($oldElements, $newElements);
        // Elements to add
        $toAdd = ArrayHelper::getNewElementsFromArrays($oldElements, $newElements);

        /** @var MealToMealSet[] $mealToMealSet */
        $mealToMealSet = $this->getMealToMealSetRepository()->getMealsForGivenMealsIdsAndMealSet($data, $toDelete);

        $now = new \DateTime();
        foreach ($mealToMealSet as $item) {
            $item->setDeleted(true);
            $item->setDeletedAt($now);
        }

        foreach ($toAdd as $id) {
            if (!is_int($id)) {
                throw new WrongValueException(WrongValueException::MESSAGE);
            }
        }

        /** @var Meal[] $meals */
        $meals = $this->getMealRepository()->getMealsByIds($toAdd);

        if (count($meals) !== count($toAdd)) {
            throw new ItemNotFoundException(ItemNotFoundException::MESSAGE);
        }

        foreach ($meals as $meal) {
            if ($meal->getUserId() !== $user->getId()) {
                throw new WrongOwnerException(WrongOwnerException::MESSAGE);
            }

            $mealToMealSet = new MealToMealSet();

            $mealToMealSet->setMealSetId($data->getId());
            $mealToMealSet->setMeal($meal);
            $mealToMealSet->setMealId($meal->getId());

            $this->dbPersist($mealToMealSet);
        }
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
        $ids = $data->getMealIds();

        if ($ids) {
            $user = $this->getUserHelper()->getUser();
            $ids = json_decode($ids);
            if (is_array($ids)) {
                foreach ($ids as $id) {
                    if (!is_int($id)) {
                        throw new WrongValueException(WrongValueException::MESSAGE);
                    }

                    /** @var Meal $meal */
                    $meal = $this->getMealRepository()->find($id);

                    if (!$meal) {
                        throw new ItemNotFoundException(ItemNotFoundException::MESSAGE);
                    }

                    if ($meal->getDeletedAt() && $meal->getDeleted()) {
                        throw new ItemNotFoundException(ItemNotFoundException::MEAL_NOT_FOUND_MESSAGE);
                    }

                    if ($meal->getUserId() !== $user->getId()) {
                        throw new WrongOwnerException(WrongOwnerException::MESSAGE);
                    }
                }
            } else {
                throw new WrongValueException(WrongValueException::MESSAGE);
            }
        }
    }

}