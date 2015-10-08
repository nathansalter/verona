<?php

namespace Verona\Timetable;

interface TimetableManagerInterface
{
	
	/**
	 * Sets the current point in time
	 * 
	 * @param \DateTime $dateTime
	 * @return $this
	 */
	public function setPointInTime(\DateTime $dateTime);
	
	/**
	 * Get the current date and time
	 * 
	 * @return \DateTime
	 */
	public function getPointInTime() : \DateTime;
	
	/**
	 * Saves the current point in time for the next request
	 * 
	 * @return $this
	 */
	public function savePointInTime();
	
}