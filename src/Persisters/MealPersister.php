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
        return parent::persist($data,$context);
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
        $this->checkIfUserHasHisOwnIngredients($data);
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
        $ids = $data->getIngredientIds();

        if($ids) {
            $ids = json_decode($ids);
            if(is_array($ids)) {
                foreach($ids as $id) {
                    $ingredientToMeal = new IngredientToMeal();

                    $ingredientToMeal->setIngredientId($id);
                    $ingredientToMeal->setMealId($data->getId());

                    $this->dbPersist($ingredientToMeal);
                }

                $this->dbFlush();
            }
        }
    }

    public function preUpdate($data, $context = []): void {
        $this->checkIfUserHasHisOwnIngredients($data);
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
    public function postUpdate($data, $context = []): void {
        $oldElements = [];
        $newElements = [];
        $user = $this->getUserHelper()->getUser();

        // Get assigned elements
        /** @var IngredientToMeal[] $assignedIngredients */
        $assignedIngredients = $this->getIngredientToMealRepository()->getAllIngredientForGivenMeal($data);
        foreach ($assignedIngredients as $assignedIngredient) {
            $oldElements[] = $assignedIngredient->getIngredientId();
        }
        // Get new elements
        $ids = $data->getIngredientIds();
        if($ids) {
            $ids = json_decode($ids);
            if (is_array($ids)) {
                $newElements = $ids;
            }
        }

        // Elements to delete
        $toDelete = ArrayHelper::getOldElementsFromArrays($oldElements, $newElements);
        // Elements to add
        $toAdd = ArrayHelper::getNewElementsFromArrays($oldElements, $newElements);

        $this->getIngredientToMealRepository()->deleteByIngredientIdsAndMealId($toDelete, $data->getId());

        foreach ($toAdd as $id) {
            if (!is_int($id)) {
                throw new WrongValueException(WrongValueException::MESSAGE);
            }
        }

        /** @var Ingredient[] $ingredients */
        $ingredients = $this->getIngredientRepository()->getIngredientsByIds($toAdd);

        if(count($ingredients) !== count($toAdd)) {
            throw new ItemNotFoundException(ItemNotFoundException::MESSAGE);
        }

        foreach($ingredients as $ingredient) {
            if($ingredient->getUserId() !== $user->getId()) {
                throw new WrongOwnerException(WrongOwnerException::MESSAGE);
            }

            $ingredientToMeal = new IngredientToMeal();

            $ingredientToMeal->setMealId($data->getId());
            $ingredientToMeal->setIngredientId($ingredient->getId());

            $this->dbPersist($ingredientToMeal);
        }
        $this->dbFlush();
    }

    public function preRemove($data, $context = []): void {}

    public function overrideRemove($data, $context = []): void {}

    public function postRemove($data, $context = []): void {}

    private function checkIfUserHasHisOwnIngredients(Meal $data): void
    {
        $ids = $data->getIngredientIds();

        if($ids) {
            $user = $this->getUserHelper()->getUser();
            $ids = json_decode($ids);
            if(is_array($ids)) {
                foreach($ids as $id) {
                    if(!is_int($id)) {
                        throw new WrongValueException(WrongValueException::MESSAGE);
                    }

                    /** @var Ingredient $ingredient */
                    $ingredient = $this->getIngredientRepository()->find($id);

                    if(!$ingredient) {
                        throw new ItemNotFoundException(ItemNotFoundException::MESSAGE);
                    }

                    if($ingredient->getUserId() !== $user->getId()) {
                        throw new WrongOwnerException(WrongOwnerException::MESSAGE);
                    }
                }
            } else {
                throw new WrongValueException(WrongValueException::MESSAGE);
            }
        }
    }

}