<?php

namespace App\Core\Exceptions\StandardExceptions;

class ItemNotFoundException extends \LogicException
{
    const MESSAGE = 'exception:message.item_not_found';
    const AMOUNT_TYPE_NOT_FOUND_MESSAGE = 'exception:message.amount_type_not_found';
    const INGREDIENT_NOT_FOUND_MESSAGE = 'exception:message.ingredient_not_found';
    const MEAL_NOT_FOUND_MESSAGE = 'exception:message.meal_not_found';
    const TRAINING_NOT_FOUND_MESSAGE = 'exception:message.training_not_found';

    const CODE = 404;

}