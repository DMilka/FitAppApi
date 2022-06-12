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

    /**
     * @param array $ids
     * @param Meal $meal
     * @return IngredientToMeal[]
     */
    public function getAllElementsToDelete(array $ids, Meal $meal): array
    {
        $query = $this->createQueryBuilder('itm')
            ->andWhere('itm.mealId = :mealId')->setParameter('mealId', $meal->getId())
            ->andWhere('itm.ingredientId not in (:ids)')->setParameter('ids', $ids)
            ->andWhere('itm.deleted = false');

        try {
            $result = $query->getQuery()->getResult();
            return $result;
        } catch (\Exception $e) {
            $this->logCritical($e->getMessage(), __METHOD__);
        }

        return [];
    }

    public function removeGivenElements(array $ids): void
    {
        $query = $this->createQueryBuilder('itm')
            ->andWhere('itm.id in (:ids)')->setParameter('ids', $ids);

        try {
            $query->getQuery()->execute();
        } catch (\Exception $e) {
            $this->logCritical($e->getMessage(), __METHOD__);
        }
    }


}
