<?php declare(strict_types=1);

namespace h4kuna\DataType\Collection;

use h4kuna\DataType\Date\Time;

/**
 * @phpstan-type Any mixed
 * @phpstan-type InfoType  array{time: float, message: Any}
 */
class Counter implements \Countable
{
	public const DISABLE_GARBAGE = 0;

	/**
	 * @var array<InfoType>
	 */
	private array $stack = [];


	/**
	 * @param int $ttl - positive = seconds, 0 = disable, negative = count in stack
	 */
	public function __construct(private int $ttl = self::DISABLE_GARBAGE)
	{
	}


	/**
	 * @param Any $message
	 */
	public function tick($message = ''): void
	{
		$this->stack[] = ['message' => $message, 'time' => Time::micro()];
	}


	/**
	 * @return InfoType|null
	 */
	public function last(): ?array
	{
		$key = array_key_last($this->stack);
		if ($key === null) {
			return null;
		}

		return $this->stack[$key];
	}


	public function isFull(): bool
	{
		if ($this->ttl === self::DISABLE_GARBAGE) {
			return false;
		} elseif ($this->ttl > 0) {
			return $this->isFullByTime(Time::micro() - $this->ttl);
		}

		return $this->isFullByCount($this->ttl * -1);
	}


	public function count(): int
	{
		$this->garbage();
		return count($this->stack);
	}


	public function reset(): void
	{
		$this->stack = [];
	}


	private function garbage(): void
	{
		if ($this->ttl === self::DISABLE_GARBAGE) {
			return;
		} elseif ($this->ttl > 0) {
			$this->garbageByTime(Time::micro() - $this->ttl);
			return;
		}

		$this->garbageByCount($this->ttl * -1);
	}


	private function garbageByTime(float $ttl): void
	{
		foreach ($this->stack as $info) {
			if ($info['time'] < $ttl) {
				array_shift($this->stack);
				continue;
			}
			break;
		}
	}


	private function garbageByCount(int $maxCount): void
	{
		$actualCount = count($this->stack);
		if ($maxCount >= $actualCount) {
			return;
		}

		$diff = $actualCount - $maxCount;
		for ($i = 0; $i < $diff; ++$i) {
			array_shift($this->stack);
		}
	}


	private function isFullByTime(float $ttl): bool
	{
		$key = array_key_first($this->stack);
		if ($key === null) {
			return false;
		}

		return $this->stack[$key]['time'] < $ttl;
	}


	private function isFullByCount(int $maxCount): bool
	{
		$actualCount = count($this->stack);
		return $maxCount < $actualCount;
	}
}
