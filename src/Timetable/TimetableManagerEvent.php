<?php

namespace Verona\Timetable;

use Zend\EventManager\Event;

class TimetableManagerEvent extends Event
{
	
	/**
	 * 
	 * @var \DateTime $pointInTime
	 */
	protected $pointInTime;
	
	/**
	 * 
	 * @param \DateTime $pointInTime
	 * @return $this
	 */
	public function setPointInTime(\DateTime $pointInTime) : self
	{
		$this->pointInTime = $pointInTime;
		return $this;
	}
	
	/**
	 * @return bool
	 */
	public function hasPointInTime() : bool
	{
		return $this->pointInTime instanceof \DateTime;
	}
	
	/**
	 * 
	 * @throws \RuntimeException
	 * @return \DateTime
	 */
	public function getPointInTime() : \DateTime
	{
		if(! $this->hasPointInTime()) {
			throw new \RuntimeException(sprintf('%s() requires that a point in time
					be set, none set', __METHOD__));
		}
		return $this->pointInTime;
	}
	
}