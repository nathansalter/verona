<?php

namespace Verona\Timetable;

interface TimetableManagerInterface
{

    /**
     * Sets the current point in time
     *
     * @param \DateTime $dateTime
     * @return TimetableManagerInterface
     */
    public function setPointInTime(\DateTime $dateTime) : TimetableManagerInterface;

    /**
     * Get the current date and time
     *
     * @return \DateTime
     */
    public function getPointInTime() : \DateTime;

    /**
     * Saves the current point in time for the next request
     *
     * @return TimetableManagerInterface
     */
    public function savePointInTime() : TimetableManagerInterface;

}