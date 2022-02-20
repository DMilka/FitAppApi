<?php

namespace App\Core\Authentication\Subscriber;

use App\Core\Authentication\Event\RegisterEvent;
use App\Core\Authentication\Handler\RegisterHandler;
use App\Core\Authentication\Handler\RegisterValidationHandler;
use App\Core\HandlerAbstract;
use App\Core\Helpers\UserHelper;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class RegisterSubscriber extends HandlerAbstract implements EventSubscriberInterface
{
    private ?RegisterEvent $registerEvent = null;
    private ?RegisterHandler $registerHandler = null;
    private ?RegisterValidationHandler $registerValidationHandler = null;

    public function __construct(ManagerRegistry $managerRegistry, EventDispatcherInterface $eventDispatcher, UserHelper $userHelper)
    {
        parent::__construct($managerRegistry, $eventDispatcher, $userHelper);
        $this->registerHandler = new RegisterHandler($managerRegistry, $eventDispatcher, $userHelper);
        $this->registerValidationHandler = new RegisterValidationHandler($managerRegistry, $eventDispatcher, $userHelper);

    }

    public static function getSubscribedEvents(): array
    {
        return [
            RegisterEvent::class => [
                ['validateUser', 8192],
                ['checkUserExist', 4096],
                ['createUser', 1],
            ]
        ];
    }

    public function createUser(RegisterEvent $registerEvent): RegisterEvent
    {
        $user = $this->registerHandler->handleRegister($registerEvent->getParams());
        $registerEvent->setUsers($user);

        return $registerEvent;
    }

    public function validateUser(RegisterEvent $registerEvent): RegisterEvent
    {
        $this->registerValidationHandler->validateUser($registerEvent->getParams());

        return $registerEvent;
    }

    public function checkUserExist(RegisterEvent $registerEvent): RegisterEvent
    {
        $this->registerValidationHandler->checkUserExist($registerEvent->getParams());

        return $registerEvent;
    }
}