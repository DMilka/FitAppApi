<?php

namespace App\Core\Security;

use App\Core\HandlerAbstract;
use App\Core\Helpers\UserHelper;
use App\Entity\Users;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

abstract class ExtensionAbstract extends HandlerAbstract implements ExtensionInterface
{
    protected UserHelper $userHelper;

    public function __construct(ManagerRegistry $managerRegistry, LoggerInterface $logger, EventDispatcherInterface $eventDispatcher, UserHelper $userHelper)
    {
        parent::__construct($managerRegistry, $logger, $eventDispatcher, $userHelper);
        $this->userHelper = $userHelper;
    }

    abstract protected function getResourceClass(): string;

    protected function checkResourceClass(string $resourceClass): bool
    {
        return $this->getResourceClass() === $resourceClass;
    }

    protected function fillWithUserId(QueryBuilder $queryBuilder, Users $user)
    {
        $rootAlias = $queryBuilder->getRootAliases()[0];
        $queryBuilder->andWhere($rootAlias . '.userId = :userId' )->setParameter('userId', $user->getId());
    }
}