<?php

use Verona\Timetable\Listener\TimetableCookieListener;
use Verona\Timetable\TimetableManagerEvent;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Http\Headers;

class TimetableCookieListenerTest extends PHPUnit_Framework_TestCase
{
	
	public function testGet()
	{
		
		$expectedDate = '2015-01-01';
		
		$headers = new Headers();
		$headers->addHeaderLine(sprintf('Cookie: %s=%s', TimetableCookieListener::COOKIE_NAME, $expectedDate));
		
		$request = new Request();
		$request->setHeaders($headers);
		$response = new Response();
		
		
		$listener = new TimetableCookieListener($request, $response);
		
		$event = new TimetableManagerEvent();
		
		$listener->getTime($event);
		
		$this->assertTrue($event->hasPointInTime());
		$this->assertEquals($expectedDate, $event->getPointInTime()->format('Y-m-d'));
		
	}
	
	public function testSave()
	{
		
		$expectedDate = new \DateTime('2015-01-01');
		
		$request = new Request('GET', 'http://example.com');
		$response = new Response();
		
		$listener = new TimetableCookieListener($request, $response);
		
		$event = new TimetableManagerEvent();
		$event->setPointInTime($expectedDate);
		
		$listener->storeTime($event);
		
		$this->assertTrue($response->getHeaders()->has('Set-Cookie'));
		
		$cookie = current($response->getHeaders()->get('Set-Cookie'));
		
		$this->assertEquals($expectedDate, new \DateTime($cookie->getValue()));
		
	}
	
}