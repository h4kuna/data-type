<?php declare(strict_types=1);

namespace h4kuna\DataType\Basic;

use h4kuna\DataType;

final class Floats
{

	private function __construct()
	{
	}


	/**
	 * @param string|int|float $value
	 * @throws \h4kuna\DataType\Exceptions\InvalidArgumentsException
	 */
	public static function fromString($value, string $decimalPoint = ',', string $thousands = ' '): float
	{
		if (is_float($value)) {
			return $value;
		} elseif (is_numeric($value)) {
			return (float) $value;
		} elseif ($value === '') {
			throw new DataType\Exceptions\InvalidArgumentsException('This value is not float: ' . $value);
		}

		if (strstr($value, ':') !== false) {
			return self::fromHour($value);
		}

		$out = str_replace([$thousands, $decimalPoint], ['', '.'], $value);
		if (!is_numeric($out)) {
			throw new DataType\Exceptions\InvalidArgumentsException('This value is not float: ' . $value);
		}

		return (float) $out;
	}


	/**
	 * Format HH:MM or HH:MM:SS
	 */
	public static function fromHour(string $value): float
	{
		$minus = false;
		if (substr($value, 0, 1) === '-') {
			$minus = true;
			$value = substr($value, 1);
		}
		$out = 0.0;
		foreach (explode(':', $value) as $i => $v) {
			$out += (Ints::fromString($v) / pow(60, $i));
		}

		return $minus ? $out * -1 : $out;
	}

}
