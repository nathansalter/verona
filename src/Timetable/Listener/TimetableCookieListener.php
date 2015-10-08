<?php

namespace Verona\Timetable\Listener;

use Verona\Event\EventSubscriberInterface;
use Verona\Http\RequestAwareTrait;
use Verona\Http\ResponseAwareTrait;
use Verona\Timetable\TimetableManagerEvent;
use Verona\Timetable\TimetableManagerEvents;
use Zend\Http\Request;
use Zend\Http\Response;

class TimetableCookieListener implements EventSubscriberInterface
{
	use RequestAwareTrait,
		ResponseAwareTrait;
	
	const COOKIE_NAME = 'veronaPointInTime';
	
	/**
	 * 
	 * @param Request $request
	 * @param Response $response
	 */
	public function __construct(Request $request, Response $response)
	{
		$this->setRequest($request)
			->setResponse($response);
	}
	
	/**
	 * 
	 * @param TimetableManagerEvent $event
	 */
	public function getTime(TimetableManagerEvent $event)
	{
		if($this->getRequest()->getCookie()->offsetExists(self::COOKIE_NAME)) {
			$point = $this->getRequest()->getCookie()->offsetGet(self::COOKIE_NAME);
			$event->setPointInTime(new \DateTime($point));
		}
	}
	
	/**
	 * 
	 * @param TimetableManagerEvent $event
	 */
	public function storeTime(TimetableManagerEvent $event)
	{
		if($event->hasPointInTime()) {
			$point = urlencode($event->getPointInTime()->format(\DateTime::ISO8601));
			$this->getResponse()->getHeaders()->addHeaderLine(sprintf('Set-Cookie: %s=%s', self::COOKIE_NAME, $point));
		}
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \Verona\Event\EventSubscriberInterface::getSubscribedEvents()
	 */
	public function getSubscribedEvents() : array
	{
		return [
			TimetableManagerEvents::GET_TIME => [$this, 'getTime'],
			TimetableManagerEvents::STORE_TIME => [$this, 'storeTime']
		];
	}
	
}