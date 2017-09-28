<?php

namespace h4kuna\DataType\Immutable;

use h4kuna\DataType;

class Messenger implements \ArrayAccess, \Iterator, \Serializable, \JsonSerializable, \Countable
{

	/** @var array */
	private $data;


	public function __construct(array $data)
	{
		$this->data = $data;
	}


	final public function __get($name)
	{
		return $this->data[$name];
	}


	final public function __isset($name)
	{
		return isset($this->data[$name]);
	}


	final public function __unset($name)
	{
		throw new DataType\FrozenMethodException();
	}


	final public function __set($name, $value)
	{
		throw new DataType\FrozenMethodException();
	}


	final public function get($key, $default = null)
	{
		if ($this->offsetExists($key)) {
			return $this->offsetGet($key);
		}
		return $default;
	}


	final public function getData()
	{
		return $this->data;
	}


	final public function current()
	{
		return current($this->data);
	}


	final public function next()
	{
		next($this->data);
	}


	final public function key()
	{
		return key($this->data);
	}


	final public function valid()
	{
		return $this->key() !== null;
	}


	final public function rewind()
	{
		reset($this->data);
	}


	final public function offsetGet($offset)
	{
		return $this->data[$offset];
	}


	final public function offsetSet($offset, $value)
	{
		throw new DataType\FrozenMethodException();
	}


	final public function offsetUnset($offset)
	{
		throw new DataType\FrozenMethodException();
	}


	final public function offsetExists($offset)
	{
		return array_key_exists($offset, $this->data);
	}


	final public function serialize()
	{
		return serialize($this->data);
	}


	final public function unserialize($serialized)
	{
		$this->data = unserialize($serialized);
	}


	final public function count()
	{
		return count($this->data);
	}


	public function jsonSerialize()
	{
		return $this->data;
	}
}

