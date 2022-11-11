<?php

namespace App\EntityProcesses\IngredientToMeal;

use ApiPlatform\Metadata\Operation;
use App\Core\Api\EntityProcessAbstract;
use App\Core\Api\EntityProcessInterface;
use App\Core\Exceptions\StandardExceptions\EntityProcessException;
use App\Core\Exceptions\StandardExceptions\ItemNotFoundException;
use App\Core\Exceptions\StandardExceptions\WrongOwnerException;
use App\Core\Exceptions\StandardExceptions\WrongValueException;
use App\Entity\IngredientToMeal;
use App\Entity\Meal;

class IngredientToMealPostProcess extends EntityProcessAbstract implements EntityProcessInterface
{
    /**
     * @param IngredientToMeal $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return void
     */
    public function executePreProcess(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $mealId = $data->getMealId();
        /**
         * @var Meal $meal
         */
        $meal = $this->getMealRepository()->find($mealId);
        if($this->getUserId() !== $meal->getUserId()) {
            throw new WrongOwnerException(WrongOwnerException::MESSAGE, WrongOwnerException::CODE);
        }

        $ingredient = $data->getIngredient();
        if(!$ingredient) {
            $ingredientId = $data->getIngredientId();
            if(!$ingredientId) {
                throw new ItemNotFoundException(ItemNotFoundException::INGREDIENT_NOT_FOUND_MESSAGE, ItemNotFoundException::CODE);
            }
            $ingredient = $this->getIngredientRepository()->find($ingredientId);
            if(!$ingredient) {
                throw new ItemNotFoundException(ItemNotFoundException::INGREDIENT_NOT_FOUND_MESSAGE, ItemNotFoundException::CODE);
            }
        }

        if($this->getUserId() !== $ingredient->getUserId()) {
            throw new WrongOwnerException(WrongOwnerException::MESSAGE, WrongOwnerException::CODE);
        }

        if($data->getAmount() === 0 || $data->getAmount() === null) {
            throw new WrongValueException(WrongValueException::MESSAGE, WrongValueException::CODE);
        }
    }

    /**
     * @param IngredientToMeal $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return void
     */
    public function executeProcess(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        try {
            $this->getManager()->beginTransaction();
            $this->getManager()->persist($data);
            $this->getManager()->flush();
            $this->getManager()->commit();
        } catch (\Exception $exception) {
            $this->logCritical($exception->getMessage(), __METHOD__);
            $this->getManager()->rollback();
            throw new EntityProcessException(EntityProcessException::MESSAGE, EntityProcessException::CODE);
        }
    }
}