<?php

namespace Verona\Timetable;

use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\EventManager\EventManagerInterface;
use Verona\Event\EventSubscriberInterface;

class TimetableManager implements TimetableManagerInterface, EventManagerAwareInterface
{
	
	use EventManagerAwareTrait;
	
	/**
	 * 
	 * @var \DateTime
	 */
	protected $point;
	
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
				foreach($subscriber as $event => $callable) {
					$this->getEventManager()->attach($event, $callable);
				}
			}
		}
	}
	
	/**
	 * Sets the current point in time
	 *
	 * @param \DateTime $dateTime
	 * @return $this
	 */
	public function setPointInTime(\DateTime $dateTime) : self
	{
		$this->point = $dateTime;
		$event = new TimetableManagerEvent();
		$event->setName(TimetableManagerEvents::SET_TIME)
			->setPointInTime($this->point);
		$this->getEventManager()->trigger($event, $this);
	}
	
	/**
	 * Get the current date and time
	 *
	 * @return \DateTime
	 */
	public function getPointInTime() : \DateTime
	{
		if($this->point instanceof \DateTime) {
			return $this->point;
		}
		
		// Retrieve the current point in time
		$event = new TimetableManagerEvent();
		$event->setName(TimetableManagerEvents::GET_TIME)
			->setPointInTime($this->point);
		$this->getEventManager()->trigger($event, $this);
		
		if($event->hasPointInTime()) {
			return $event->getPointInTime();
		}
		
		//Default to now
		return new \DateTime();
	}
	
	/**
	 * Saves the current point in time for the next request
	 *
	 * @return $this
	 */
	public function savePointInTime() : self
	{
		$event = new TimetableManagerEvent();
		$event->setName(TimetableManagerEvents::STORE_TIME)
			->setPointInTime($this->point);
		$this-getEventManager()->trigger($event, $this);
		
	}
	
}