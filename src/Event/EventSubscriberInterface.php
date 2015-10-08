<?php

namespace Verona\Event;

interface EventSubscriberInterface
{
	
	/**
	 * Returns a list of callable events for the event manager
	 *  
	 * @return array
	 */
	public function getSubscribedEvents() : array;
	
}