<?php declare(strict_types=1);

namespace h4kuna\DataType\Immutable;

use h4kuna\DataType;

/**
 * @template T of int|string
 * @implements \ArrayAccess<T, mixed>
 * @implements \Iterator<T, mixed>
 */
class Messenger implements \ArrayAccess, \Iterator, \Serializable, \JsonSerializable, \Countable
{

	/** @var array<T, mixed> */
	private $data;


	/**
	 * @param array<T, mixed> $data
	 */
	public function __construct(array $data)
	{
		$this->data = $data;
	}


	/**
	 * @param T $name
	 * @return mixed
	 */
	final public function __get($name)
	{
		return $this->data[$name];
	}


	/**
	 * @param T $name
	 * @return bool
	 */
	final public function __isset($name)
	{
		return isset($this->data[$name]);
	}


	/**
	 * @param T $name
	 */
	final public function __unset($name): void
	{
		throw new DataType\Exceptions\LogicException('Use "$cloneMessenger = $messenger->remove($key)" instand of "unset($messenger->key)".');
	}


	/**
	 * @param T $name
	 * @param mixed $value
	 */
	final public function __set($name, $value): void
	{
		throw new DataType\Exceptions\LogicException('Use "$cloneMessenger = $messenger->add($key, $value)" instand of "$messenger->key = \'foo\';".');
	}


	/**
	 * @param T $key
	 * @param mixed $value
	 * @return static
	 */
	final public function add($key, $value)
	{
		$data = $this->data;
		$data[$key] = $value;

		return new static($data);
	}


	/**
	 * @param T $key
	 */
	final public function exists($key): bool
	{
		return array_key_exists($key, $this->data);
	}


	/**
	 * @param T $key
	 * @return static
	 */
	final public function remove(...$key)
	{
		$data = $this->data;
		foreach ($key as $k) {
			unset($data[$k]);
		}

		return new static($data);
	}


	/**
	 * @param T $key
	 * @param mixed $default
	 * @return mixed|null
	 */
	final public function get($key, $default = null)
	{
		if ($this->offsetExists($key)) {
			return $this->offsetGet($key);
		}

		return $default;
	}


	/**
	 * @return array<T, mixed>
	 */
	final public function getData()
	{
		return $this->data;
	}


	/**
	 * @return mixed
	 */
	#[\ReturnTypeWillChange]
	final public function current()
	{
		return current($this->data);
	}


	final public function next(): void
	{
		next($this->data);
	}


	/**
	 * @return T|null
	 */
	#[\ReturnTypeWillChange]
	final public function key()
	{
		$value = key($this->data);

		return $value;
	}


	final public function valid(): bool
	{
		return $this->key() !== null;
	}


	final public function rewind(): void
	{
		reset($this->data);
	}


	/**
	 * @param T $offset
	 * @return mixed
	 */
	#[\ReturnTypeWillChange]
	final public function offsetGet($offset)
	{
		return $this->data[$offset];
	}


	/**
	 * @param T $offset
	 * @param mixed $value
	 * @return void
	 */
	#[\ReturnTypeWillChange]
	final public function offsetSet($offset, $value)
	{
		$this->__set($offset, $value);
	}


	/**
	 * @param T $offset
	 * @return void
	 */
	#[\ReturnTypeWillChange]
	final public function offsetUnset($offset)
	{
		$this->__unset($offset);
	}


	/**
	 * @param T $offset
	 * @return bool
	 */
	#[\ReturnTypeWillChange]
	final public function offsetExists($offset)
	{
		return $this->__isset($offset);
	}


	final public function serialize(): string
	{
		return serialize($this->data);
	}


	/**
	 * @param string $serialized
	 */
	final public function unserialize($serialized): void
	{
		$this->data = unserialize($serialized);
	}


	final public function __serialize(): array
	{
		return $this->data;
	}


	public function __unserialize(array $data): void
	{
		$this->data = $data;
	}


	final public function count(): int
	{
		return count($this->data);
	}


	/**
	 * @return array<T, mixed>
	 */
	#[\ReturnTypeWillChange]
	public function jsonSerialize()
	{
		return $this->data;
	}

}
