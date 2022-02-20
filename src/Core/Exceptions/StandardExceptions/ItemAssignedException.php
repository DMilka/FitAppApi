<?php

namespace App\Core\Exceptions\StandardExceptions;

use ApiPlatform\Core\Exception\ExceptionInterface;
use LogicException;

class ItemAssignedException extends LogicException implements ExceptionInterface
{
    const MESSAGE = 'exception:message.item_assigned';
    const CODE = 403;
}