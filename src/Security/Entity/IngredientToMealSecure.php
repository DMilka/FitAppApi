<?php

namespace App\Security\Entity;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\AmountType;
use App\Core\Security\ExtensionAbstract;
use App\Core\Security\ExtensionInterface;
use App\Entity\Ingredient;
use Doctrine\ORM\QueryBuilder;

class IngredientToMealSecure extends ExtensionAbstract implements ExtensionInterface
{
    public function prepareQueryForCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null, array $context = [])
    {
        if (!$this->checkResourceClass($this->getResourceClass())) {
            return;
        }

        if (!array_key_exists('filters', $context)) {
            return;
        }

        if (!array_key_exists('mealId', $context['filters'])) {
            return;
        }

        
    }

    public function prepareQueryForItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null, array $context = [])
    {
        if (!$this->checkResourceClass($this->getResourceClass())) {
            return;
        }
    }

    public function getResourceClass(): string
    {
        return IngredientToMealSecure::class;
    }
}