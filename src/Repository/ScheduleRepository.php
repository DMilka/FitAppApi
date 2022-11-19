<?php

namespace App\Repository;

use App\Core\Logger\LoggerTrait;
use App\Entity\Schedule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ScheduleRepository extends ServiceEntityRepository
{
    use LoggerTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Schedule::class);
    }

    public function findNotDeleted(int $id): ?Schedule
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
