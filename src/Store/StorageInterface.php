<?php

namespace Verona\Store;

interface StorageInterface
{
	
	/**
	 * 
	 * @param string $type
	 * @param string $id
	 * @param \DateTime
	 * @return array
	 */
	public function get(string $type, string $id, \DateTime $at) : array;
	
	/**
	 * 
	 * @param string $type
	 * @param string $id
	 * @param array $data
	 * @return $this
	 */
	public function store(string $type, string $id, array $data);
	
}