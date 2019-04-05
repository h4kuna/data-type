<?php declare(strict_types=1);

namespace h4kuna\DataType\Basic;

use h4kuna\DataType;

final class Floats
{

	private function __construct() { }

	/**
	 * @param string|int|float $value
	 * @param string $decimalPoint
	 * @param string $thousands
	 * @return float
	 * @throws DataType\InvalidArgumentsException
	 */
	public static function fromString($value, $decimalPoint = ',', $thousands = ' ')
	{
		if (is_float($value)) {
			return $value;
		}

		if (is_numeric($value)) {
			return (float) $value;
		}

		if (strstr($value, ':') !== false) {
			return self::fromHour($value);
		}

		$out = str_replace([$thousands, $decimalPoint], ['', '.'], $value);

		if (!is_numeric($out)) {
			throw new DataType\InvalidArgumentsException('This value is not float: ' . $value);
		}

		return (float) $out;
	}

	/**
	 * Format HH:MM or HH:MM:SS
	 */
	public static function fromHour(string $value): float
	{
		$value = preg_replace('~-~', '', $value, 1, $count);
		$out = 0.0;
		foreach (explode(':', $value) as $i => $v) {
			$out += (Ints::fromString($v) / pow(60, $i));
		}
		return $count === 1 ? $out * -1 : $out;
	}

}
