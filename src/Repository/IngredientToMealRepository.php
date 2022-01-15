<?php

namespace App\Repository;

use App\Entity\Ingredient;
use App\Entity\IngredientToMeal;
use App\Entity\Meal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class IngredientToMealRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IngredientToMeal::class);
    }

    public function getAllIngredientForGivenMeal(Meal $meal): array
    {
        $query = $this->createQueryBuilder('itm')
            ->andWhere('itm.mealId = :id')
            ->setParameter('id', $meal->getId());

        try {
            $result = $query->getQuery()->getResult();
            return $result;
        } catch (\Exception $e) {
            $this->logCritical($e->getMessage(), __METHOD__);
        }

        return [];
    }

    public function getOneByMealAndIngredientId(Meal $meal, int $ingredientId): ?IngredientToMeal
    {
        $query = $this->createQueryBuilder('itm')
            ->andWhere('itm.mealId = :id')
            ->andWhere('itm.ingredientId = :id2')
            ->setParameter('id', $meal->getId())
            ->setParameter('id2', $ingredientId);

        try {
            $result = $query->getQuery()->getOneOrNullResult();
            return $result;
        } catch (\Exception $e) {
            $this->logCritical($e->getMessage(), __METHOD__);
        }

        return null;
    }
}
