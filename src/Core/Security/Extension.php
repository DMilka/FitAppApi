<?php

namespace App\Core\Security;

use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Core\Database\HelperEntity\SoftDelete;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Extension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    const ENTITY_PATH = 'App\Entity';
    const SECURE_PATH = 'Security\Entity';
    const CLASS_SUFFIX = 'Secure';

    /** @var ContainerInterface */
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
    {
        if (strpos($resourceClass, self::ENTITY_PATH) === false) {
            return;
        }

        $class = new $resourceClass();
        if ($class instanceof SoftDelete) {
            $rootAlias = $queryBuilder->getRootAliases()[0];
            $queryBuilder->andWhere($rootAlias . '.deleted = false');
        }

        $className = preg_replace('/Entity/', self::SECURE_PATH, $resourceClass . self::CLASS_SUFFIX);
        if (class_exists($className)) {
            /** @var ExtensionInterface $object */
            $object = $this->container->get($className);
            $object->prepareQueryForCollection($queryBuilder, $queryNameGenerator, $resourceClass, $operation, $context);
        }

    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, Operation $operation = null, array $context = []): void
    {
        if (strpos($resourceClass, self::ENTITY_PATH) === false) {
            return;
        }

        $class = new $resourceClass();
        if ($class instanceof SoftDelete) {
            $rootAlias = $queryBuilder->getRootAliases()[0];
            $queryBuilder->andWhere($rootAlias . '.deleted = false');
        }

        $className = preg_replace('/Entity/', self::SECURE_PATH, $resourceClass . self::CLASS_SUFFIX);
        if (class_exists($className)) {
            /** @var ExtensionInterface $object */
            $object = $this->container->get($className);
            $object->prepareQueryForItem($queryBuilder, $queryNameGenerator, $resourceClass, $operation, $context);
        }
    }
}