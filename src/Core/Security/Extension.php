<?php

namespace App\Core\Security;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Core\Database\HelperEntity\SoftDelete;
use Doctrine\ORM\QueryBuilder;
use Psr\Container\ContainerInterface;
use Symfony\Component\Security\Core\Security;

class Extension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    const ENTITY_PATH = 'App\Entity';
    const SECURE_PATH = 'Security\Entity';
    const CLASS_SUFFIX = 'Secure';

    /** @var ContainerInterface $container */
    private ContainerInterface $container;

    /** @var Security $security */
    private Security $security;

    public function __construct(ContainerInterface $container, Security $security)
    {
        $this->container = $container;
        $this->security = $security;
    }

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null, array $context = [])
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
            $object->prepareQueryForCollection($queryBuilder, $queryNameGenerator, $resourceClass, $operationName, $context);
        }

    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, string $operationName = null, array $context = [])
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
            $object->prepareQueryForItem($queryBuilder, $queryNameGenerator, $resourceClass, $operationName, $context);
        }
    }
}