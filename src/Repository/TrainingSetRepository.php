<?php

namespace App\Repository;

use App\Entity\AmountType;
use App\Entity\Training;
use App\Entity\TrainingSet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TrainingSetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrainingSet::class);
    }
}
