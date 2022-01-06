<?php declare(strict_types=1);

namespace h4kuna\DataType\Basic;

use h4kuna\DataType;

final class Ints
{

	private function __construct() { }

	/**
	 * @param string|int $value
	 * @throws DataType\InvalidArgumentsException
	 */
	public static function fromString($value): int
	{
		if (is_int($value)) {
			return $value;
		}

		if (is_numeric($value) && $value == ((int) $value)) {
			return (int) $value;
		}
		$out = preg_replace('~\s~', '', $value);
		$int = (int) $out;
		if ($out != $int) {
			throw new DataType\InvalidArgumentsException('Input value is not integer. ' . $out);
		}

		return $int;
	}

}
