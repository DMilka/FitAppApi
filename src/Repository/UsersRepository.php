<?php

namespace App\Repository;

use App\Core\Logger\LoggerTrait;
use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UsersRepository extends ServiceEntityRepository
{
    use LoggerTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Users::class);
    }

    public function findOneOrNullByUserName(string $name): ?Users
    {
        $query = $this->createQueryBuilder('u')
            ->andWhere('u.username = :name')
            ->andWhere('itm.deleted = false')
            ->setParameter('name', $name)
            ->setMaxResults(1);

        try {
            $result = $query->getQuery()->getOneOrNullResult();
            return $result;
        } catch (\Exception $e) {
            $this->logCritical($e->getMessage(), __METHOD__);
        }

        return null;
    }

    public function findOneOrNullByEmail(string $email): ?Users
    {
        $query = $this->createQueryBuilder('u')
            ->andWhere('u.email = :email')
            ->andWhere('itm.deleted = false')
            ->setParameter('email', $email)
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
