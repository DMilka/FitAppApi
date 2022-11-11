<?php

namespace App\EntityProcesses\IngredientToMeal;

use ApiPlatform\Metadata\Operation;
use App\Core\Api\EntityProcessAbstract;
use App\Core\Exceptions\StandardExceptions\EntityProcessException;
use App\Core\Helpers\DateHelper;
use App\Entity\IngredientToMeal;
use App\Entity\Meal;

class IngredientToMealDeleteProcess extends EntityProcessAbstract
{
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

            $data->setDeleted(true);
            $data->setDeletedAt(DateHelper::getActualDate());

            $this->getManager()->flush();
            $this->getManager()->commit();
        } catch (\Exception $exception) {
            $this->logCritical($exception->getMessage(), __METHOD__);
            $this->getManager()->rollback();
            throw new EntityProcessException(EntityProcessException::MESSAGE, EntityProcessException::CODE);
        }
    }

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
            if ($data->getAmount() !== $ingredient->getAmount()) {
                $multiplier = $data->getAmount() / $ingredient->getAmount();
            }

            $sumProtein = $ingredient->getProtein() * $multiplier;
            $sumCarbohydrate = $ingredient->getCarbohydrate() * $multiplier;
            $sumFat = $ingredient->getFat() * $multiplier;
            $sumCalorie = $ingredient->getCalorie() * $multiplier;

            $meal->setProtein($meal->getProtein() - $sumProtein);
            $meal->setCarbohydrate($meal->getCarbohydrate() - $sumCarbohydrate);
            $meal->setFat($meal->getFat() - $sumFat);
            $meal->setCalorie($meal->getCalorie() - $sumCalorie);

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