<?php

namespace Verona\Http;

use Zend\Http\Request;

trait RequestAwareTrait
{
	
	/**
	 * 
	 * @var Request $request
	 */
	protected $request;
	
	/**
	 * 
	 * @return bool
	 */
	public function hasRequest() : bool
	{
		return $this->request instanceof Request;
	}
	
	/**
	 * 
	 * @param Request $request
	 * @return $this
	 */
	public function setRequest(Request $request) : self
	{
		$this->request = $request;
		return $this;
	}
	
	/**
	 * 
	 * @throws \RuntimeException
	 * @return Request
	 */
	public function getRequest() : Request
	{
		if(! $this->hasRequest()) {
			throw new \RuntimeException(sprintf('%s() expects request to be set,
					none set', __METHOD__));
		}
		return $this->request;
	}
	
}