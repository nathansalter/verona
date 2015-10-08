<?php

namespace Verona\Item;

final class ItemFactoryEvents
{
	
	/**
	 * Build the actual class
	 * 
	 * @var string
	 */
	const PREPARE_ITEM = 'itemFactory.prepareItem';
	
	/**
	 * Build the definition for the item
	 * 
	 * @var string
	 */
	const DEFINE_ITEM = 'itemFactory.defineItem';
	
	/**
	 * When the item is loaded from the cache
	 * 
	 * @var string
	 */
	const CACHED_ITEM = 'itemFactory.cachedItem';
	
}