<?php

namespace Verona\Store;

interface StorageInterface
{

    /**
     * Returns true if this document exists
     *
     * @param string $type
     * @param $id
     * @param \DateTime $at
     * @return bool
     */
    public function has(string $type, $id, \DateTime $at) : bool;

    /**
     * Returns the configuration for the given ID/Date
     *
     * @param string $type
     * @param string $id
     * @param \DateTime
     * @return array
     */
    public function get(string $type, string $id, \DateTime $at) : array;

    /**
     * Stores/Updates the given ID/Date combination
     *
     * @param string $type
     * @param string $id
     * @param array $data
     * @return StorageInterface
     */
    public function store(string $type, string $id, array $data) : StorageInterface;

}