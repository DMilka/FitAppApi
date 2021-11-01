<?php

namespace App\Core\Database;

use App\Entity\AmountType;
use App\Entity\Ingredient;
use App\Entity\Users;
use App\Repository\AmountTypeRepository;
use App\Repository\IngredientRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

trait HandlerDatabaseTrait
{
    private function getRepositoryForClass(string $className): EntityRepository
    {
        /** @var EntityRepository $repository */
        $repository = $this->getManager()->getRepository($className);
        return $repository;
    }

    public function getManager(): EntityManager
    {
        /** @var EntityManager $manager */
        $manager = $this->managerRegistry->getManager();
        return $manager;
    }
    public function getUserRepository(): UsersRepository
    {
        return $this->getRepositoryForClass(Users::class);
    }

    public function getAmountTypeRepository(): AmountTypeRepository
    {
        return $this->getRepositoryForClass(AmountType::class);
    }

    public function getIngredientRepository(): IngredientRepository
    {
        return $this->getRepositoryForClass(Ingredient::class);
    }
}