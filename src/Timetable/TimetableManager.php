<?php

namespace Verona\Timetable;

use Verona\Event\EventSubscriberInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\EventManager\EventManagerInterface;

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
        if ($eventManager instanceof EventManagerInterface) {
            $this->setEventManager($eventManager);
        }

        foreach ($subscribers as $subscriber) {
            if ($subscriber instanceof EventSubscriberInterface) {
                foreach ($subscriber as $event => $callable) {
                    $this->getEventManager()->attach($event, $callable);
                }
            }
        }
    }

    /**
     * Sets the current point in time
     *
     * @param \DateTime $dateTime
     * @return TimetableManagerInterface
     */
    public function setPointInTime(\DateTime $dateTime) : TimetableManagerInterface
    {
        $this->point = $dateTime;
        $event = new TimetableManagerEvent();
        $event->setPointInTime($this->point)
            ->setName(TimetableManagerEvents::SET_TIME);
        $this->getEventManager()->trigger($event, $this);
    }

    /**
     * Get the current date and time
     *
     * @return \DateTime
     */
    public function getPointInTime() : \DateTime
    {
        if ($this->point instanceof \DateTime) {
            return $this->point;
        }

        // Retrieve the current point in time
        $event = new TimetableManagerEvent();
        $event->setPointInTime($this->point)
            ->setName(TimetableManagerEvents::GET_TIME);
        $this->getEventManager()->trigger($event, $this);

        if ($event->hasPointInTime()) {
            return $event->getPointInTime();
        }

        //Default to now
        return new \DateTime();
    }

    /**
     * Saves the current point in time for the next request
     *
     * @return TimetableManagerInterface
     */
    public function savePointInTime() : TimetableManagerInterface
    {
        $event = new TimetableManagerEvent();
        $event->setPointInTime($this->point)
            ->setName(TimetableManagerEvents::STORE_TIME);

        $this->getEventManager()->trigger($event, $this);

        return $this;
    }

}