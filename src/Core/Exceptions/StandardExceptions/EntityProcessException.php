<?php

namespace App\Core\Exceptions\StandardExceptions;


class EntityProcessException extends \LogicException
{
    const MESSAGE = 'exception:entity_process.error';
    const CODE = 500;

}