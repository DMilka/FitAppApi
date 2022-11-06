<?php

namespace App\Persisters\Core;


use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;

interface CustomDataPersisterInterface extends ProcessorInterface
{
     public function prePersist($data, Operation $operation, array $uriVariables = [], array $context = []): void;
     public function overridePersist($data, array $context = []): void;
     public function postPersist($data, array $context = []): void;

     public function preUpdate($data, array $context = []): void;
     public function update($data, array $context = []): void;
     public function postUpdate($data, array $context = []): void;

     public function preRemove($data, array $context = []): void;
     public function overrideRemove($data, array $context = []): void;
     public function postRemove($data, array $context = []): void;
}