<?php

namespace App\Security\Entity;

use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Core\Security\ExtensionAbstract;
use App\Core\Security\ExtensionInterface;
use App\Entity\Ingredient;
use Doctrine\ORM\QueryBuilder;

class IngredientSecure extends ExtensionAbstract implements ExtensionInterface
{
    public function prepareQueryForCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null, array $context = [])
    {
        if(!$this->checkResourceClass($this->getResourceClass())) {
            return;
        }


        $this->fillWithUserId($queryBuilder, $this->userHelper->getUser());
    }

    public function prepareQueryForItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null, array $context = [])
    {
        if(!$this->checkResourceClass($this->getResourceClass())) {
            return;
        }

        $this->fillWithUserId($queryBuilder, $this->userHelper->getUser());
    }

    public function getResourceClass(): string
    {
        return Ingredient::class;
    }
}