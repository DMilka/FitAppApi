<?php

namespace App\EntityProcesses\MealToMealSet;

use ApiPlatform\Metadata\Operation;
use App\Core\Api\EntityProcessAbstract;
use App\Core\Api\EntityProcessInterface;
use App\Core\Exceptions\StandardExceptions\EntityProcessException;
use App\Core\Exceptions\StandardExceptions\ItemNotFoundException;
use App\Core\Exceptions\StandardExceptions\WrongOwnerException;
use App\Entity\MealSet;
use App\Entity\MealToMealSet;

class MealToMealSetPutProcess extends EntityProcessAbstract implements EntityProcessInterface
{
    /**
     * @param MealToMealSet $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return void
     */
    public function executePreProcess(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $mealSetId = $data->getMealSetId();
        /**
         * @var MealSet $mealSet
         */
        $mealSet = $this->getMealSetRepository()->find($mealSetId);
        if($this->getUserId() !== $mealSet->getUserId()) {
            throw new WrongOwnerException(WrongOwnerException::MESSAGE, WrongOwnerException::CODE);
        }

        $meal = $data->getMeal();
        if(!$meal) {
            $mealId = $data->getMealId();
            if(!$mealId) {
                throw new ItemNotFoundException(ItemNotFoundException::MEAL_NOT_FOUND_MESSAGE, ItemNotFoundException::CODE);
            }
            $meal = $this->getMealRepository()->find($mealId);
            if(!$meal) {
                throw new ItemNotFoundException(ItemNotFoundException::MEAL_NOT_FOUND_MESSAGE, ItemNotFoundException::CODE);
            }
        }

        if($this->getUserId() !== $meal->getUserId()) {
            throw new WrongOwnerException(WrongOwnerException::MESSAGE, WrongOwnerException::CODE);
        }
    }

    /**
     * @param MealToMealSet $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return void
     */
    public function executeProcess(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        parent::executeProcess($data, $operation, $uriVariables, $context);
    }

    /**
     * @param MealToMealSet $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return void
     */
    public function executePostProcess(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $mealSetId = $data->getMealSetId();
        /**
         * @var MealSet $mealSet
         */
        $mealSet = $this->getMealSetRepository()->find($mealSetId);

        if($mealSet) {
            /**
             * @var MealToMealSet[] $mealToMealSets
             */
            $mealToMealSets = $this->getMealToMealSetRepository()->getAllMealToMealSetByMealSet($mealSet);

            $sumProtein = 0;
            $sumCarbohydrate = 0;
            $sumFat = 0;
            $sumCalorie = 0;
            foreach ($mealToMealSets as $mealToMealSet) {
                $meal = $mealToMealSet->getMeal();

                $sumProtein += $meal->getProtein();
                $sumCarbohydrate += $meal->getCarbohydrate();
                $sumFat += $meal->getFat();
                $sumCalorie += $meal->getCalorie();
            }

            $mealSet->setProtein($sumProtein);
            $mealSet->setCarbohydrate($sumCarbohydrate);
            $mealSet->setFat($sumFat);
            $mealSet->setCalorie($sumCalorie);

            try {
                $this->getManager()->beginTransaction();
                $this->getManager()->flush();
                $this->getManager()->commit();
            } catch (\Exception $exception) {
                $this->logCritical($exception->getMessage(), __METHOD__);
                $this->getManager()->rollback();
                throw new EntityProcessException(EntityProcessException::MESSAGE, EntityProcessException::CODE);
            }
        }
    }
}