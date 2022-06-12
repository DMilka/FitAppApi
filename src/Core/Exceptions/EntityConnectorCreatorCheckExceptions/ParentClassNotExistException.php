<?php

namespace App\Core\Exceptions\EntityConnectorCreatorCheckExceptions;

use ApiPlatform\Core\Exception\ExceptionInterface;
use LogicException;

class ParentClassNotExistException extends LogicException implements ExceptionInterface
{
    const MESSAGE = 'exception:entity_connector.parent_class_not_exist';
    const CODE = 404;
}