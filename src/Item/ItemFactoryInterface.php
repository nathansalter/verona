<?php

namespace Verona\Item;


interface ItemFactoryInterface
{

    /**
     * Gets the item with the given prototype
     *
     * @param ItemInterface $itemPrototype
     * @return ItemInterface
     */
    public function getItem(ItemInterface $itemPrototype) : ItemInterface;

    /**
     * Stores the given item
     *
     * @param ItemInterface $item
     * @return ItemFactoryInterface
     */
    public function storeItem(ItemInterface $item) : ItemFactoryInterface;

}