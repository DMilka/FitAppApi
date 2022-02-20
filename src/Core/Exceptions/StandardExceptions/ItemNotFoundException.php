<?php

namespace App\Core\Exceptions\StandardExceptions;

use ApiPlatform\Core\Exception\ExceptionInterface;

class ItemNotFoundException extends \LogicException implements ExceptionInterface
{
    const MESSAGE = 'exception:message.item_not_found';
    const AMOUNT_TYPE_NOT_FOUND_MESSAGE = 'exception:message.amount_type_not_found';
    const INGREDIENT_NOT_FOUND_MESSAGE = 'exception:message.ingredient_not_found';
    
    const CODE = 404;

}