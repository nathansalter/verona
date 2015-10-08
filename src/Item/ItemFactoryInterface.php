<?php

namespace Verona\Item;

use Verona\Value\ItemValue;

interface ItemFactoryInterface
{
	
	/**
	 * 
	 * @param string $name
	 * @return ItemValue
	 */
	public function getItem(string $name) : ItemValue;
	
}