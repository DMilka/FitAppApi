<?php

namespace App\Repository;

use App\Core\Logger\LoggerTrait;
use App\Entity\Ingredient;
use App\Entity\IngredientToMeal;
use App\Entity\Meal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class IngredientToMealRepository extends ServiceEntityRepository
{
    use LoggerTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IngredientToMeal::class);
    }

    public function getAllIngredientForGivenMeal(Meal $meal): array
    {
        $query = $this->createQueryBuilder('itm')
            ->andWhere('itm.mealId = :id')
            ->andWhere('itm.deleted = false')
            ->setParameter('id', $meal->getId());

        try {
            $result = $query->getQuery()->getResult();
            return $result;
        } catch (\Exception $e) {
            $this->logCritical($e->getMessage(), __METHOD__);
        }

        return [];
    }

    public function getIngredientsForGivenIngredientIdsAndMeal(Meal $meal, array $ids): array
    {
        $query = $this->createQueryBuilder('itm')
            ->andWhere('itm.ingredientId in (:ids)')
            ->andWhere('itm.mealId = :mealId')
            ->andWhere('itm.deleted = false')
            ->setParameter('ids', $ids)
            ->setParameter('mealId', $meal->getId());

        try {
            $result = $query->getQuery()->getResult();
            return $result;
        } catch (\Exception $e) {
            $this->logCritical($e->getMessage(), __METHOD__);
        }

        return [];
    }

    public function getAllIngredientToMealByIngredient(Ingredient $ingredient): array
    {
        $query = $this->createQueryBuilder('itm')
            ->andWhere('itm.ingredientId = :id')
            ->andWhere('itm.deleted = false')
            ->setParameter('id', $ingredient->getId());

        try {
            $result = $query->getQuery()->getResult();
            return $result;
        } catch (\Exception $e) {
            $this->logCritical($e->getMessage(), __METHOD__);
        }

        return [];
    }


}
