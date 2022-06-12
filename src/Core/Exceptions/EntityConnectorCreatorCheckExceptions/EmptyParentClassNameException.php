<?php

namespace App\Core\Exceptions\EntityConnectorCreatorCheckExceptions;

use ApiPlatform\Core\Exception\ExceptionInterface;
use LogicException;

class EmptyParentClassNameException extends LogicException implements ExceptionInterface
{
    const MESSAGE = 'exception:entity_connector.empty_parent_class_name';
    const CODE = 404;
}