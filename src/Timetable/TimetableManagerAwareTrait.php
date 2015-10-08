<?php

namespace Verona\Timetable;

trait TimetableManagerAwareTrait
{

	/**
	 * 
	 * @var TimetableManagerInterface
	 */
	protected $timetableManager;
	
	/**
	 * 
	 * @param TimetableManagerInterface $timetableManager
	 * @return $this
	 */
	public function setTimetableManager(TimetableManagerInterface $timetableManager) : self
	{
		$this->timetableManager = $timetableManager;
		return $this;
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function hasTimetableManager() : bool
	{
		return $this->timetableManager instanceof TimetableManagerInterface;
	}
	
	/**
	 * 
	 * @throws \RuntimeException
	 * @return \Verona\Timetable\TimetableManagerInterface
	 */
	public function getTimetableManager() : TimetableManagerInterface
	{
		if(! $this->hasTimetableManager()) {
			throw new \RuntimeException(sprintf('%s() expects to have a timetable
					manager, none set', __METHOD__));
		}
		return $this->timetableManager;
	}
	
}