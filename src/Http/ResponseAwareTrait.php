<?php

namespace Verona\Http;

use GuzzleHttp\Psr7\Response;

class ResponseAwareTrait
{
	
	/**
	 * 
	 * @var Response $request
	 */
	protected $request;
	
	/**
	 * 
	 * @return bool
	 */
	public function hasResponse() : bool
	{
		return $this->request instanceof Response;
	}
	
	/**
	 * 
	 * @param Response $request
	 * @return $this
	 */
	public function setResponse(Response $request) : self
	{
		$this->request = $request;
		return $this;
	}
	
	/**
	 * 
	 * @throws \RuntimeException
	 * @return Response
	 */
	public function getResponse() : Response
	{
		if(! $this->hasResponse()) {
			throw new \RuntimeException(sprintf('%s() expects request to be set,
					none set', __METHOD__));
		}
		return $this->request;
	}
	
}