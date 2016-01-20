<?php

namespace Verona\Store;

trait StorageAwareTrait
{

    /**
     *
     * @var StorageInterface
     */
    protected $storage;

    /**
     *
     * @return bool
     */
    public function hasStorage() : bool
    {
        return $this->storage instanceof StorageInterface;
    }

    /**
     *
     * @throws \RuntimeException
     * @return StorageInterface
     */
    public function getStorage() : StorageInterface
    {
        if (!$this->hasStorage()) {
            throw new \RuntimeException(sprintf('%s() expects to have a store availabe
					none set', __METHOD__));
        }
        return $this->storage;
    }

    /**
     *
     * @param StorageInterface $store
     * @return $this
     */
    public function setStorage(StorageInterface $store)
    {
        $this->storage = $store;
        return $this;
    }

}
