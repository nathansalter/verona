<?php

namespace Verona\Timetable\Listener;

use Verona\Event\EventSubscriberInterface;
use Verona\Http\RequestAwareTrait;
use Verona\Http\ResponseAwareTrait;
use Verona\Timetable\TimetableManagerEvent;
use Verona\Timetable\TimetableManagerEvents;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use function GuzzleHttp\Psr7\parse_header;

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
		if($this->getRequest()->hasHeader('Cookie')) {
			$cookies = parse_header($this->getRequest()->getHeader());
			if(isset($cookies[self::COOKIE_NAME])) {
				$event->setPointInTime(new \DateTime($cookies[self::COOKIE_NAME]));
			}
		}
	}
	
	/**
	 * 
	 * @param TimetableManagerEvent $event
	 */
	public function storeTime(TimetableManagerEvent $event)
	{
		if($event->hasPointInTime()) {
			$point = $event->getPointInTime()->format(\DateTime::ISO8601);
			$this->getResponse()->setHeader('Set-Cookie', [self::COOKIE_NAME => $point]);
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