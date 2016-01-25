<?php
use Verona\Item\ItemFactoryEvent;
use Verona\Item\ItemInterface;

/**
 * Created by PhpStorm.
 * User: Nathan
 * Date: 25/01/2016
 * Time: 10:36
 */
class ItemFactoryEventTest extends PHPUnit_Framework_TestCase
{

    public function testGettersAndSetters()
    {

        $event = new ItemFactoryEvent();

        $expectedItem = $this->getMock(ItemInterface::class);
        $this->assertFalse($event->hasItem());
        $this->assertInstanceOf(ItemFactoryEvent::class, $event->setItem($expectedItem));
        $this->assertTrue($event->hasItem());
        $this->assertEquals($expectedItem, $event->getItem());

    }
}
