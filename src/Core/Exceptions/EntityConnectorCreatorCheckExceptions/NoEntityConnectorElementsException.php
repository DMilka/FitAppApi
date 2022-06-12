<?php

namespace App\Core\Exceptions\EntityConnectorCreatorCheckExceptions;

use ApiPlatform\Core\Exception\ExceptionInterface;
use LogicException;

class NoEntityConnectorElementsException extends LogicException implements ExceptionInterface
{
    const MESSAGE = 'exception:entity_connector.no_entity_connector_elements';
    const CODE = 404;
}