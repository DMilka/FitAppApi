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

    public function getMealsForGivenMealsIdsAndMealSet(MealSet $mealSet, array $ids): array
    {
        $query = $this->createQueryBuilder('itm')
            ->andWhere('itm.mealId in (:ids)')
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

    public function getAllMealsForMealSet(MealSet $meal): array
    {
        $query = $this->createQueryBuilder('mtms')
            ->andWhere('mtms.mealSetId = :id')
            ->andWhere('mtms.deleted = false')
            ->setParameter('id', $meal->getId());

        try {
            $result = $query->getQuery()->getResult();
            return $result;
        } catch (\Exception $e) {
            $this->logCritical($e->getMessage(), __METHOD__);
        }

        return [];
    }
}
