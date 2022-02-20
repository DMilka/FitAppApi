<?php

namespace App\Persisters\Core;


interface CustomDataPersisterInterface
{
     public function prePersist($data, array $context = []): void;
     public function overridePersist($data, array $context = []): void;
     public function postPersist($data, array $context = []): void;

     public function preUpdate($data, array $context = []): void;
     public function update($data, array $context = []): void;
     public function postUpdate($data, array $context = []): void;

     public function preRemove($data, array $context = []): void;
     public function overrideRemove($data, array $context = []): void;
     public function postRemove($data, array $context = []): void;
}