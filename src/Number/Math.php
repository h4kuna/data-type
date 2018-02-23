<?php

namespace h4kuna\DataType\Number;

use h4kuna\DataType;

/**
 * @author Milan Matějček
 */
final class Math
{

	private function __construct() { }

	/**
	 * Allow number in interval and correct it.
	 * @param float|int $number
	 * @param float|int $max
	 * @param float|int $min
	 * @return Floats
	 * @throws DataType\InvalidArgumentsException
	 */
	public static function interval($number, $max, $min = 0)
	{
		if ($max < $min) {
			throw new DataType\InvalidArgumentsException('Maximum is less than minimum.');
		}
		return max($min, min($max, $number));
	}

	/**
	 * Round method to zero point five.
	 * @example 1.24 -> 1.0, 1.25 -> 1.5, 1.74 -> 1.5, 1.75 -> 2.0
	 * @param float $num
	 * @return float
	 */
	public static function round5($num)
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
		return $floor + (1 * $i);
	}

	/**
	 * Safe division.
	 * @param Floats $up
	 * @param Floats $down
	 * @return Floats|Ints|NULL
	 */
	public static function safeDivision($up, $down)
	{
		if (!$down) {
			return null;
		}
		return $up / $down;
	}

	/**
	 * Factorial.
	 * @param int $n
	 * @return int
	 * @throws DataType\InvalidArgumentsException
	 */
	public static function factorial($n)
	{
		if ($n == 0) {
			return 1;
		}
		if ($n < 0) {
			throw new DataType\InvalidArgumentsException('The number cann\'t negative number.');
		}
		return $n * self::factorial($n - 1);
	}

}
