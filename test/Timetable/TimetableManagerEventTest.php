<?php
use Verona\Timetable\TimetableManagerEvent;

/**
 * Created by PhpStorm.
 * User: Nathan
 * Date: 25/01/2016
 * Time: 10:59
 */
class TimetableManagerEventTest extends PHPUnit_Framework_TestCase
{

    public function testGettersAndSetters()
    {

        $event = new TimetableManagerEvent();

        $expectedPointInTime = new DateTime();
        $this->assertFalse($event->hasPointInTime());
        $this->assertInstanceOf(TimetableManagerEvent::class, $event->setPointInTime($expectedPointInTime));
        $this->assertTrue($event->hasPointInTime());
        $this->assertEquals($expectedPointInTime, $event->getPointInTime());

    }
}
