<?php

use Verona\Item\Listener\ItemConfigListener;
use Verona\Value\ListValue;
use Verona\Store\StorageInterface;
use Verona\Timetable\TimetableManagerInterface;
use Verona\Item\ItemFactoryEvent;
use Verona\Value\ItemValue;

class ItemConfigListenerTest extends PHPUnit_Framework_TestCase
{
	
	public function testAttach()
	{
		
		$expectedConfig = [
			'rawr' => 'bool',
			'hi' => 'string',
			'class' => ListValue::class
		];
		
		$store = $this->getMock(StorageInterface::class);
		$store->expects($this->once())
			->method('get')
			->willReturn($expectedConfig);
		
		$timetableManager = $this->getMock(TimetableManagerInterface::class);
		$timetableManager->expects($this->once())
			->method('getPointInTime')
			->willReturn(new \DateTime());
		
		$listener = new ItemConfigListener($store, $timetableManager);
		
		$item = new ItemValue();
		
		$event = new ItemFactoryEvent();
		$event->setItem($item)
			->setItemName('test');
		
		$listener->attachDefinition($event);
		
		foreach($expectedConfig as $key => $_) {
			$this->assertTrue($item->hasDefinition($key));
		}
		
	}
	
}