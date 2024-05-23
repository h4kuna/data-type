<?php declare(strict_types=1);

namespace h4kuna\DataType\Number;

use DateTimeInterface;
use h4kuna\DataType;
use h4kuna\DataType\Exceptions\InvalidArgumentsException;

final class Math
{

	/**
	 * Allow number in interval and correct it.
	 * @template T of float|int|DateTimeInterface
	 * @param T $number
	 * @param T|null $max
	 * @param T|null $min
	 *
	 * @return T
	 */
	public static function interval(
		float|int|DateTimeInterface $number,
		float|int|DateTimeInterface|null $max,
		float|int|DateTimeInterface|null $min = 0
	): float|int|DateTimeInterface
	{
		if ($max !== null && $min !== null && $max < $min) {
			throw new InvalidArgumentsException('Maximum is less than minimum.');
		}

		if ($min === null && $max === null) {
			return $number;
		} elseif ($min === null) {
			return min($max, $number);
		} elseif ($max === null) {
			return max($min, $number);
		}

		return max($min, min($max, $number));
	}


	/**
	 * Round method to zero point five.
	 * @example 1.24 -> 1.0, 1.25 -> 1.5, 1.74 -> 1.5, 1.75 -> 2.0
	 */
	public static function round5(float|int $num): float|int
	{
		if ($num < 0) {
			$floor = ceil($num);
			$i = -1;
		} else {
			$floor = floor($num);
			$i = 1;
		}
		$decimal = abs($num - $floor);
		if ($decimal < 0.25) {
			return $floor;
		}

		if (0.25 <= $decimal && $decimal < 0.75) {
			return $floor + (0.5 * $i);
		}

		return $floor + $i;
	}


	public static function safeDivision(float|int $up, float|int $down): ?float
	{
		if ($down == 0) {
			return null;
		}

		return $up / $down;
	}


	public static function factorial(int $n): int
	{
		if ($n == 0) {
			return 1;
		}
		if ($n < 0) {
			throw new InvalidArgumentsException('The number can\'t negative number.');
		}

		return $n * self::factorial($n - 1);
	}

}
