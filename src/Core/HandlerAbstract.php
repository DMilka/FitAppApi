<?php

namespace App\Core;

use App\Core\Exceptions\StandardExceptions\UserNotFound;
use App\Core\Helpers\UserHelper;
use App\Core\Logger\LoggerTrait;
use App\Core\Database\HandlerDatabaseTrait;
use App\Entity\Users;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

abstract class HandlerAbstract extends AbstractController
{
    use HandlerDatabaseTrait, LoggerTrait;

    /** @var ManagerRegistry $managerRegistry */
    private ManagerRegistry $managerRegistry;

    /** @var EventDispatcherInterface|null $eventDispatcher */
    private EventDispatcherInterface $eventDispatcher;

    /** @var UserHelper $userHelper */
    private UserHelper $userHelper;

    public function __construct(ManagerRegistry $managerRegistry, LoggerInterface $logger, EventDispatcherInterface $eventDispatcher, UserHelper $userHelper)
    {
        $this->managerRegistry = $managerRegistry;
        $this->eventDispatcher = $eventDispatcher;
        $this->logger = $logger;
        $this->userHelper = $userHelper;
    }

    public function getEventDispatcher(): ?EventDispatcherInterface
    {
        return  $this->eventDispatcher;
    }

    public function dbPersist(object $object):void
    {
        try {
            $this->getManager()->persist($object);
        } catch(\Exception $exception) {
            $this->logCritical($exception->getMessage(), __METHOD__);
        }
    }

    public function dbFlush():void
    {
        try {
            $this->getManager()->flush();
        } catch (\Exception $exception) {
            $this->logCritical($exception->getMessage(),__METHOD__);
        }
    }

    public function dbRemove(object $object): void
    {
        try {
            $this->getManager()->remove($object);
        } catch (\Exception $exception) {
            $this->logCritical($exception->getMessage(),__METHOD__);
        }
    }

    public function getUser(): Users
    {
        return $this->userHelper->getUser();
    }

    public function getUserId(): int
    {
        $user = $this->getUser();
        if(!$user) {
            throw new UserNotFound(UserNotFound::MESSAGE, UserNotFound::CODE);
        }

        if(!$user->getId()) {
            throw new UserNotFound(UserNotFound::MESSAGE, UserNotFound::CODE);
        }

        return $user->getId();
    }

    public function getUserHelper(): UserHelper
    {
        return $this->userHelper;
    }
}