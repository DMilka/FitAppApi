<?php

namespace App\Core\Exceptions\EntityConnectorCreatorCheckExceptions;

use ApiPlatform\Core\Exception\ExceptionInterface;
use LogicException;

class InvalidElementValueException extends LogicException implements ExceptionInterface
{
    const MESSAGE = 'exception:entity_connector.invalid_element_value';
    const CODE = 404;
}