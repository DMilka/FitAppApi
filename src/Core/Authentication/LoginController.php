<?php

namespace App\Core\Authentication;

use App\Core\Authentication\Helper\AuthenticationHelper;
use App\Entity\Users;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class LoginController
{
    /**
     * @var RequestStack
     */
    private RequestStack $requestStack;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $data  = $event->getData();

        /** @var Users $user */
        $user = $event->getUser();

        $data[AuthenticationHelper::LOGIN] = $user->getId();

        $event->setData($data);
    }

}