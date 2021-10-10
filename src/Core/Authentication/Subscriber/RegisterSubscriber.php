<?php

namespace App\Core\Authentication\Subscriber;

use App\Core\Authentication\Event\RegisterEvent;
use App\Core\Authentication\Handler\RegisterHandler;
use App\Core\Authentication\Handler\RegisterValidationHandler;
use App\Core\HandlerAbstract;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class RegisterSubscriber extends HandlerAbstract implements EventSubscriberInterface
{
    private ?RegisterEvent $registerEvent = null;
    private ?RegisterHandler $registerHandler = null;
    private ?RegisterValidationHandler $registerValidationHandler = null;

    public function __construct(ManagerRegistry $managerRegistry, EventDispatcherInterface $eventDispatcher)
    {
        parent::__construct($managerRegistry, $eventDispatcher);
        $this->registerHandler = new RegisterHandler($managerRegistry, $eventDispatcher);
        $this->registerValidationHandler = new RegisterValidationHandler($managerRegistry, $eventDispatcher);

    }

    public static function getSubscribedEvents(): array
    {
        return [
            RegisterEvent::class => [
                ['validateUser', 8192],
                ['createUser', 4096],
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
}