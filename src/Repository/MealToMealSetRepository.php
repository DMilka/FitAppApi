<?php

namespace App\Repository;

use App\Entity\MealSet;
use App\Entity\MealToMealSet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MealToMealSetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MealToMealSet::class);
    }

    public function getAllMealToMealSetByMealSet(MealSet $mealSet): array
    {
        $query = $this->createQueryBuilder('itm')
            ->andWhere('itm.mealSetId = :id')
            ->andWhere('itm.deleted = false')
            ->setParameter('id', $mealSet->getId());

        try {
            $result = $query->getQuery()->getResult();
            return $result;
        } catch (\Exception $e) {
            $this->logCritical($e->getMessage(), __METHOD__);
        }

        return [];
    }

    /**
     * @param int[] $ingredientIds
     * @param MealSet $meal
     * @return array
     */
    public function getElementsToDeleteByIngredientArrAndMealSetId(MealSet $mealSet, array $ids): array
    {
        $query = $this->createQueryBuilder('itm')
            ->andWhere('itm.ingredientId not in (:ids)')
            ->andWhere('itm.mealId is null')
            ->andWhere('itm.mealSetId = :mealSetId')
            ->andWhere('itm.deleted = false')
            ->setParameter('ids', $ids)
            ->setParameter('mealSetId', $mealSet->getId());

        try {
            $result = $query->getQuery()->getResult();
            return $result;
        } catch (\Exception $e) {
            $this->logCritical($e->getMessage(), __METHOD__);
        }

        return [];
    }

    /**
     * @param int[] $mealIds
     * @param MealSet $meal
     * @return array
     */
    public function getElementsToDeleteByMealArrAndMealSetId(MealSet $mealSet, array $mealIds): array
    {
        $query = $this->createQueryBuilder('itm')
            ->andWhere('itm.mealId not in (:ids)')
            ->andWhere('itm.ingredientId is null')
            ->andWhere('itm.mealSetId = :mealSetId')
            ->andWhere('itm.deleted = false')
            ->setParameter('ids', $mealIds)
            ->setParameter('mealSetId', $mealSet->getId());

        try {
            $result = $query->getQuery()->getResult();
            return $result;
        } catch (\Exception $e) {
            $this->logCritical($e->getMessage(), __METHOD__);
        }

        return [];
    }
}
