<?php

namespace App\Core\Exceptions\EntityConnectorCreatorCheckExceptions;

use ApiPlatform\Core\Exception\ExceptionInterface;
use LogicException;

class NoEntityConnectorNameException extends LogicException implements ExceptionInterface
{
    const MESSAGE = 'exception:entity_connector.no_entity_connector_name';
    const CODE = 404;
}