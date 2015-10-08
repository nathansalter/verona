<?php

namespace Verona\Item;

use Zend\EventManager\EventManagerAwareTrait;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Verona\Event\EventSubscriberInterface;
use Verona\Value\ItemValue;

class ItemFactory implements ItemFactoryInterface, EventManagerAwareInterface
{
	use EventManagerAwareTrait;
	
	/**
	 * 
	 * @var ItemValue[] $itemCache
	 */
	protected $itemCache;
	
	/**
	 * 
	 * @param array $subscribers
	 * @param EventManagerInterface $eventManager
	 */
	public function __construct(array $subscribers, EventManagerInterface $eventManager = null)
	{
		if($eventManager instanceof EventManagerInterface) {
			$this->setEventManager($eventManager);
		}
		
		foreach($subscribers as $subscriber) {
			
			if($subscriber instanceof EventSubscriberInterface) {
				foreach($subscriber->getSubscribedEvents() as $event => $callable) {
					$this->getEventManager()->attach($event, $callable);
				}
			}
			
		}
	}
	
	/**
	 * 
	 * @param string $name
	 * @return bool
	 */
	public function hasCache(string $name) : bool
	{
		return array_key_exists($name, $this->itemCache);
	}

	/**
	 * 
	 * @param string $name
	 * @throws \InvalidArgumentException
	 * @return ItemValue
	 */
	public function getCache(string $name) : ItemValue
	{
		if(! $this->hasCache($name)) {
			throw new \InvalidArgumentException(sprintf('%s(%s) This is not an item 
					which is in the cache', __METHOD__, $name));
		}
		return $this->itemCache[$name];
	}
	
	/**
	 * 
	 * @param string $name
	 * @param ItemValue $item
	 * @return $this
	 */
	public function setCache(string $name, ItemValue $item) : self
	{
		$this->itemCache[$name] = $item;
		return $this;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \Verona\Item\ItemFactoryInterface::getItem($name)
	 */
	public function getItem(string $name) : ItemValue
	{
		
		$event = new ItemFactoryEvent();
		
		if($this->hasCache($name)) {
			$event->setName(ItemFactoryEvents::CACHED_ITEM);
			$event->setItem($this->getItem($name));
			$this->getEventManager()->trigger($event, $this);
		} else {
			$event->setName(ItemFactoryEvents::PREPARE_ITEM);
			$this->getEventManager()->trigger($event, $this);
			if(! $event->hasItem()) {
				$event->setItem(new ItemValue());
			}
			$event->setName(ItemFactoryEvents::DEFINE_ITEM);
			$this->getEventManager()->trigger($event, $this);
			if(! $event->getItem()->hasDefinitions()) {
				throw new \RuntimeException(sprintf('%s() should have a defined
						item by now, nothing defined', __METHOD__));
			}
		}
		
		return $this->getItem($name);
		
	}
	
}