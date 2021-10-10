<?php

namespace App\Core\Authentication;

use App\Core\Authentication\Event\RegisterEvent;
use App\Core\HandlerAbstract;
use App\Entity\Users;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class RegisterController extends HandlerAbstract
{
    public function __construct(ManagerRegistry $managerRegistry, EventDispatcherInterface $eventDispatcher)
    {
        parent::__construct($managerRegistry, $eventDispatcher);
    }

    public function onRegister(Request $request): Response
    {
        $parameters = json_decode($request->getContent(), true);

        $registerEvent = new RegisterEvent();

        $registerEvent->setParams($parameters);
        $registerEvent->setShouldRegisterUser(true);

        $this->getEventDispatcher()->dispatch($registerEvent);

        return new Response('User created', 201);
    }
}