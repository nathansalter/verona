<?php

namespace Verona\Value;

class ItemValue
{
	
	/**
	 * 
	 * @var array
	 */
	protected $definitions;
	
	/**
	 * 
	 * @var array
	 */
	protected $attributes;
	
	public function __construct()
	{
		$this->definitions = [];
		$this->attributes = [];
	}
	
	/**
	 * Should be in the format name => type
	 * Allowable types are either the main scalar/complex types
	 * or any fully qualified class name
	 * 
	 * @param array $definition
	 * @return $this
	 */
	public function defineItem(array $definitions) : self
	{
		$this->definitions = $definitions;
		
		return $this;
	}
	
	/**
	 * 
	 * @param string $key
	 * @return bool
	 */
	public function hasDefinition(string $key) : bool
	{
		return array_key_exists($key, $this->definitions);
	}
	
	/**
	 * @return bool
	 */
	public function hasDefinitions() : bool
	{
		return count($this->definitions) > 0;
	}
	
	/**
	 * 
	 * @param string $key
	 * @param mixed $value
	 * @throws \InvalidArgumentException
	 * @return bool
	 */
	public function isDefinitionType(string $key, $value) : bool
	{
		if(! $this->hasDefinition($key)) {
			throw new \InvalidArgumentException(sprintf('%s(%s,...) is not a value in this 
					item!', __METHOD__, $key));
		}
		if(gettype($value) != 'object') {
			return $this->definitions[$key] == gettype($value);
		}
		return $this->definitions[$key] == get_class($value);
	}
	
	/**
	 * 
	 * @param string $key
	 * @param mixed $value
	 * @return $this
	 */
	public function set(string $key, $value) : self
	{
		if(! count($this->definitions)) {
			throw new \RuntimeException(sprintf('%s() must not be called before
					the item is defined', __METHOD__));
		}
		
		if(! $this->isDefinitionType($key, $value)) {
			throw new \InvalidArgumentException(sprintf('%s() was provided the
					wrong type', __METHOD__));
		}
		
		$this->attributes[$key] = $value;
		return $this;
		
	}
	
	/**
	 * 
	 * @param string $key
	 * @return bool
	 */
	public function has(string $key) : bool
	{
		return in_array($key, $this->attributes);
	}
	
	/**
	 * 
	 * @param string $key
	 * @throws \RuntimeException
	 * @return mixed
	 */
	public function get(string $key)
	{
		if(! $this->has($key)) {
			throw new \RuntimeException(sprintf('%s(%s) Check to make sure that this
					key is set', __METHOD__, $key));
		}
		
		return $this->attributes[$key];
	}
	
}