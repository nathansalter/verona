<?php

namespace Verona\Item;

use Zend\EventManager\Event;
use Verona\Value\ItemValue;

class ItemFactoryEvent extends Event
{
	
	/**
	 * 
	 * @var ItemValue $item
	 */
	protected $item;
	
	/**
	 * 
	 * @param ItemValue $item
	 * @return $this
	 */
	public function setItem(ItemValue $item) : self
	{
		$this->item = $item;
		return $this;
	}
	
	/**
	 * @return bool
	 */
	public function hasItem() : bool
	{
		return $this->item instanceof ItemValue;
	}
	
	/**
	 * 
	 * @throws \RuntimeException
	 * @return \Verona\Value\ItemValue
	 */
	public function getItem() : ItemValue
	{
		if(! $this->hasItem()) {
			throw new \RuntimeException(sprintf('%s() must have an ItemValue, none
					set', __METHOD__));
		}
		return $this->item;
	}
	
}