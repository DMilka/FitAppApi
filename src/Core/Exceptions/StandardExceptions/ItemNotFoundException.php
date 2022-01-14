<?php

namespace App\Core\Exceptions\StandardExceptions;

use ApiPlatform\Core\Exception\ExceptionInterface;

class ItemNotFoundException extends \LogicException implements ExceptionInterface
{
    const MESSAGE = 'exception:message.item_not_found';
    const CODE = 404;

}