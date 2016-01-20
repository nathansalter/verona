<?php

namespace Verona\Item;

use Zend\EventManager\Event;

class ItemFactoryEvent extends Event
{

    /**
     *
     * @var ItemInterface $item
     */
    protected $item;

    /**
     *
     * @param ItemInterface $item
     * @return ItemFactoryEvent
     */
    public function setItem(ItemInterface $item) : ItemFactoryEvent
    {
        $this->item = $item;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasItem() : bool
    {
        return $this->item instanceof ItemInterface;
    }

    /**
     *
     * @throws \RuntimeException
     * @return ItemInterface
     */
    public function getItem() : ItemInterface
    {
        if (!$this->hasItem()) {
            throw new \RuntimeException(sprintf('%s() must have an ItemInterface, none
					set', __METHOD__));
        }
        return $this->item;
    }

}