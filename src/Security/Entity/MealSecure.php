<?php

namespace App\Security\Entity;

use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Core\Security\ExtensionAbstract;
use App\Core\Security\ExtensionInterface;
use App\Entity\Meal;
use Doctrine\ORM\QueryBuilder;

class MealSecure extends ExtensionAbstract implements ExtensionInterface
{
    public function prepareQueryForCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation, array $context = [])
    {
        if(!$this->checkResourceClass($this->getResourceClass())) {
            return;
        }


        $this->fillWithUserId($queryBuilder, $this->userHelper->getUser());
    }

    public function prepareQueryForItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation, array $context = [])
    {
        if(!$this->checkResourceClass($this->getResourceClass())) {
            return;
        }

        $this->fillWithUserId($queryBuilder, $this->userHelper->getUser());
    }

    public function getResourceClass(): string
    {
        return Meal::class;
    }
}