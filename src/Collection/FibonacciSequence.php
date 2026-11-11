<?php declare(strict_types = 1);

namespace h4kuna\DataType\Collection;

final class FibonacciSequence
{

	/**
	 * The first item is always $min. Every next item is the sum of the two previous ones, where the item before $min
	 * is the highest Fibonacci number lower than $min (for 4 and 5 it is 3, so 4 gives 4, 7, 11, ...).
	 *
	 * @param positive-int $count
	 * @param positive-int $min
	 * @return non-empty-list<int<1, max>>
	 */
	public static function calculate(
		int $count = 10,
		int $min = 1,
	): array
	{
		[$previous, $next] = [1, 2];
		while ($next < $min) {
			[$previous, $next] = [$next, $previous + $next];
		}

		$numbers = [$min];
		[$previous, $current] = [$min, $previous + $min];

		for ($step = 1; $step < $count; ++$step) {
			$numbers[] = $current;
			[$previous, $current] = [$current, $previous + $current];
		}

		return $numbers;
	}

}
