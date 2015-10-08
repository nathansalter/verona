<?php

namespace Verona\Item\Listener;

use Verona\Event\EventSubscriberInterface;
use Verona\Store\StorageAwareTrait;
use Verona\Store\StorageInterface;
use Verona\Item\ItemFactoryEvents;
use Verona\Item\ItemFactoryEvent;
use Verona\Timetable\TimetableManagerAwareTrait;
use Verona\Timetable\TimetableManagerInterface;

class ItemConfigListener implements EventSubscriberInterface
{

	use StorageAwareTrait,
		TimetableManagerAwareTrait;
	
	const CONFIG_STORE = 'item_config';
	
	/**
	 * 
	 * @param StorageInterface $store
	 */
	public function __construct(StorageInterface $store, TimetableManagerInterface $timetableManager)
	{
		$this->setStorage($store)
			->setTimetableManager($timetableManager);
	}
	
	/**
	 * Attaches a configuration to an item from the store
	 * 
	 * @param ItemFactoryEvent $event
	 */
	public function attachDefinition(ItemFactoryEvent $event)
	{
		if($event->hasItem()) {
			
			$name = $event->getItemName();
			
			$config = $this->getStorage()->get(self::CONFIG_STORE, $name, $this->getTimetableManager()->getPointInTime());
			$event->getItem()->defineItem($config);
			
		}
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \Verona\Event\EventSubscriberInterface::getSubscribedEvents()
	 */
	public function getSubscribedEvents() : array
	{
		return [
			ItemFactoryEvents::DEFINE_ITEM => [$this, 'attachDefinition']
		];
	}
	
}