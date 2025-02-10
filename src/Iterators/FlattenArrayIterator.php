<?php declare(strict_types=1);

namespace h4kuna\DataType\Iterators;

use RecursiveIterator;

/**
 * @example new \RecursiveIteratorIterator(new FlattenArrayIterator($data));
 * @implements RecursiveIterator<string, mixed>
 * @phpstan-consistent-constructor
 */
class FlattenArrayIterator implements RecursiveIterator
{

	/**
	 * @var array<int|string>
	 */
	private array $keys = [];


	/**
	 * @param array<mixed> $data
	 */
	public function __construct(private array $data, private string $delimiter = '-')
	{
	}


	public function next(): void
	{
		next($this->data);
	}


	public function key(): mixed
	{
		return implode($this->delimiter, $this->keys);
	}


	public function valid(): bool
	{
		$key = key($this->data);
		if ($key === null) {
			return false;
		}
		$lastKey = (int) array_key_last($this->keys);
		$this->keys[$lastKey] = $key;

		return isset($this->data[$key]);
	}


	public function rewind(): void
	{
		reset($this->data);
		$this->keys[] = '';
	}


	public function hasChildren(): bool
	{
		return is_array($this->current());
	}


	public function current(): mixed
	{
		return current($this->data);
	}


	/**
	 * @return RecursiveIterator<string, mixed>
	 */
	public function getChildren(): ?RecursiveIterator
	{
		$current = $this->current();
		assert(is_array($current));
		$child = new static($current, $this->delimiter);
		$child->addKeys($this->keys);

		return $child;
	}


	/**
	 * @param array<int|string> $keys
	 */
	protected function addKeys(array $keys): void
	{
		$this->keys = $keys;
	}

}
