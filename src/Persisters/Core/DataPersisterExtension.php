<?php

namespace App\Persisters\Core;


use App\Core\HandlerAbstract;

abstract class DataPersisterExtension extends HandlerAbstract implements CustomDataPersisterInterface
{
    /**
     * @inheritDoc
     */
    public function persist($data, array $context = [])
    {
        if($this->getManager()->contains($data)) {
            $this->preUpdate($data, $context);
            $this->update($data,$context);
            $this->postUpdate($data,$context);
        } else {
            $this->prePersist($data,$context);
            $this->overridePersist($data,$context);
            $this->postPersist($data,$context);
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function remove($data, array $context = [])
    {
        $this->preRemove($data,$context);
        $this->overrideRemove($data,$context);
        $this->postRemove($data,$context);
    }

    abstract public function preUpdate($data, $context = []): void;
    abstract public function update($data, $context = []): void;
    abstract public function postUpdate($data, $context = []): void;
    abstract public function prePersist($data, $context = []): void;
    abstract public function overridePersist($data, $context = []): void;
    abstract public function postPersist($data, $context = []): void;
    abstract public function preRemove($data, $context = []): void;
    abstract public function overrideRemove($data, $context = []): void;
    abstract public function postRemove($data, $context = []): void;
}