<?php

namespace App\Repository;

use App\Entity\AmountType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AmountTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AmountType::class);
    }

    public function findNotDeleted(int $id): ?AmountType
    {
        $query = $this->createQueryBuilder('at')
            ->andWhere('at.id = :id')
            ->andWhere('at.deleted = false')
            ->setParameter('id', $id)
            ->setMaxResults(1);

        try {
            $result = $query->getQuery()->getOneOrNullResult();
            return $result;
        } catch (\Exception $e) {
            $this->logCritical($e->getMessage(), __METHOD__);
        }

        return null;
    }

}
