<?php


namespace Verona\Item\Type;


use Verona\Item\ItemInterface;

interface TreeTypeInterface extends ItemInterface
{

    /**
     * @param ItemInterface $item
     * @return TreeTypeInterface
     */
    public function add(ItemInterface $item) : TreeTypeInterface;

    /**
     * Return all of the children
     *
     * @return array
     */
    public function getAll() : array;

    /**
     * Get the config for all of the base attributes, not including the child objects
     *
     * @return array
     */
    public function getBaseConfig() : array;

}