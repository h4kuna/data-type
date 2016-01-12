<?php

namespace h4kuna\DataType\Basic;

use h4kuna\DataType;

/**
 * @author Milan Matějček
 */
final class Floats
{

	private function __construct() {}

	/**
	 * @param string|Ints|Floats $value
	 * @return Floats
	 * @throws DataType\InvalidArgumentsException
	 */
	public static function fromString($value)
	{
		if (is_float($value)) {
			return $value;
		}

		if (is_numeric($value)) {
			return floatval($value);
		}

		if (strstr($value, ':') !== FALSE) {
			return self::fromHour($value);
		}

		$out = preg_replace_callback('/(?:^\s?-?)|([^\,\.\w]+|,)/i', function ($found) {
			if (!isset($found[1])) {
				return trim($found[0]);
			}
			if (isset($found[1]) && $found[1] === ',') {
				return '.';
			}
			return '';
		}, $value);


		if (!is_numeric($out)) {
			throw new DataType\InvalidArgumentsException('This value is not float: ' . $value);
		}

		return floatval($out);
	}

	/**
	 * Format HH:MM or HH:MM:SS
	 * @param string $value
	 * @return Floats
	 */
	public static function fromHour($value)
	{
		$out = 0.0;
		foreach (explode(':', $value) as $i => $v) {
			$out += (Ints::fromString($v) / pow(60, $i));
		}
		return $out;
	}

}
