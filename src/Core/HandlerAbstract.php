<?php

namespace App\Core;

use App\Core\Logger\LoggerTrait;
use App\Core\Database\HandlerDatabaseTrait;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class HandlerAbstract extends AbstractController
{
    use HandlerDatabaseTrait, LoggerTrait;

    /** @var ManagerRegistry $managerRegistry */
    private ManagerRegistry $managerRegistry;

    /** @var EventDispatcherInterface|null $eventDispatcher */
    private EventDispatcherInterface $eventDispatcher;


    public function __construct(ManagerRegistry $managerRegistry, EventDispatcherInterface $eventDispatcher)
    {
        $this->managerRegistry = $managerRegistry;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function getEventDispatcher(): ?EventDispatcherInterface
    {
        return  $this->eventDispatcher;
    }


    public function persist(object $object):void
    {
        try {
            $this->getManager()->persist($object);
        } catch(\Exception $exception) {
            $this->logCritical($exception->getMessage(), __METHOD__);
        }
    }

    public function flush():void
    {
        try {
            $this->getManager()->flush();
        } catch (\Exception $exception) {
            $this->logCritical($exception->getMessage(),__METHOD__);
        }
    }
}