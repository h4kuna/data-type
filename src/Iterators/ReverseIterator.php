<?php declare(strict_types=1);

namespace h4kuna\DataType\Iterators;

use Iterator;

/**
 * @template TKey=int|string
 * @template TValue=mixed
 * @implements Iterator<TKey, TValue>
 */
class ReverseIterator implements Iterator
{
	/**
	 * @var TKey
	 */
	private mixed $key;


	/**
	 * @param array<TKey, TValue> $array
	 */
	public function __construct(
		private array $array,
	)
	{
	}


	public function current(): mixed
	{
		/** @var TValue $value */
		$value = current($this->array);

		return $value;
	}


	public function next(): void
	{
		prev($this->array);
	}


	public function key(): mixed
	{
		return $this->key;
	}


	public function valid(): bool
	{
		$this->key = key($this->array); // @phpstan-ignore-line

		return $this->key !== null;
	}


	public function rewind(): void
	{
		end($this->array);
	}
}
