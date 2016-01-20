<?php

namespace Verona\Timetable;

final class TimetableManagerEvents
{

    /**
     * This event is triggered when the time is set
     *
     * @var string
     */
    const SET_TIME = 'timetableManager.setTime';

    /**
     * This event is triggered when the time is retrieved
     *
     * @var string
     */
    const GET_TIME = 'timetableManager.getTime';

    /**
     * This event is triggered when a client wants to save the current point in time
     *
     * @var string
     */
    const STORE_TIME = 'timetableManager.storeTime';

}