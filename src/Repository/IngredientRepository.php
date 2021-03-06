<?php

namespace App\Repository;

use App\Core\Logger\LoggerTrait;
use App\Entity\AmountType;
use App\Entity\Ingredient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class IngredientRepository extends ServiceEntityRepository
{
    use LoggerTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ingredient::class);
    }

    public function getIngredientsByIds(array $ids): array
    {
        $query = $this->createQueryBuilder('i')
            ->andWhere('i.id IN (:id)')
            ->andWhere('i.deleted = false')
            ->setParameter('id', $ids);

        try {
            $result = $query->getQuery()->getResult();
            return $result;
        } catch (\Exception $e) {
            $this->logCritical($e->getMessage(), __METHOD__);
        }

        return [];
    }

    public function getIngredientsByAmountType(AmountType $amountType): array
    {
        $query = $this->createQueryBuilder('i')
            ->andWhere('i.amountTypeId = :id')
            ->andWhere('i.deleted = false')
            ->setParameter('id', $amountType->getId());

        try {
            $result = $query->getQuery()->getResult();
            return $result;
        } catch (\Exception $e) {
            $this->logCritical($e->getMessage(), __METHOD__);
        }

        return [];
    }
}
