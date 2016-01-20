<?php


namespace Verona\Item;


interface ItemInterface
{

    /**
     * Defines the item
     *
     * @return string
     */
    public function getId() : string;

    /**
     * Converts the object to an array
     *
     * @return array
     */
    public function toArray() : array;

    /**
     * Takes an array and
     * @param array $data
     * @return ItemInterface
     */
    public function fromArray(array $data) : ItemInterface;

}