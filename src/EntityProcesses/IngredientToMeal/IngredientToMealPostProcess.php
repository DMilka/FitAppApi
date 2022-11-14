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

        $data->setIngredient($ingredient);
    }

    /**
     * @param IngredientToMeal $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return void
     */
    public function executePostProcess(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $mealId = $data->getMealId();
        /**
         * @var Meal $meal
         */
        $meal = $this->getMealRepository()->find($mealId);

        if($meal) {
            $ingredient = $data->getIngredient();

            $multiplier = 1;
            if($data->getAmount() !== $ingredient->getAmount()) {
                $multiplier = $data->getAmount() / $ingredient->getAmount();
            }

            $sumProtein = $ingredient->getProtein() * $multiplier;
            $sumCarbohydrate = $ingredient->getCarbohydrate() * $multiplier;
            $sumFat = $ingredient->getFat() * $multiplier;
            $sumCalorie = $ingredient->getCalorie() * $multiplier;

            $meal->setProtein($meal->getProtein() + $sumProtein);
            $meal->setCarbohydrate($meal->getCarbohydrate() + $sumCarbohydrate);
            $meal->setFat($meal->getFat() + $sumFat);
            $meal->setCalorie($meal->getCalorie() + $sumCalorie);

            try {
                $this->getManager()->flush();
            } catch (\Exception $exception) {
                $this->logCritical($exception->getMessage(), __METHOD__);
                $this->getManager()->rollback();
                throw new EntityProcessException(EntityProcessException::MESSAGE, EntityProcessException::CODE);
            }
        }
    }
}