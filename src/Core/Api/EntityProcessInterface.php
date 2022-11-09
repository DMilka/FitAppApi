<?php

namespace App\Core\Api;

use ApiPlatform\Metadata\Operation;

interface EntityProcessInterface
{
    public function executeProcess(mixed $data, Operation $operation, array $uriVariables = [], array $context = []);
}