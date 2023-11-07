<?php declare(strict_types=1);

namespace h4kuna\DataType\Iterators;

use Iterator;

/**
 * @implements Iterator<mixed, mixed>
 */
final class ReverseArray implements Iterator
{
	/**
	 * @param array<mixed, mixed> $array
	 */
	public function __construct(private array $array)
	{
	}


	public function current(): mixed
	{
		return current($this->array);
	}


	public function next(): void
	{
		prev($this->array);
	}


	public function key(): mixed
	{
		return key($this->array);
	}


	public function valid(): bool
	{
		return key($this->array) !== null;
	}


	public function rewind(): void
	{
		end($this->array);
	}

}
