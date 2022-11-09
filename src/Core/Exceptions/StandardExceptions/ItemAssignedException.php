<?php

namespace App\Core\Exceptions\StandardExceptions;

use LogicException;

class ItemAssignedException extends LogicException
{
    const MESSAGE = 'exception:message.item_assigned';
    const CODE = 403;
}