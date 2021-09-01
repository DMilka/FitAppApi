<?php

namespace App\Providers;

use App\Entity\Users;

class UsersProvider
{
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Users::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
        return [];
    }
}