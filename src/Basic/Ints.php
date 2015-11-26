<?php

namespace h4kuna\DataType\Basic;

use h4kuna\DataType;

/**
 * @author Milan Matějček
 */
final class Ints
{

	private function __construct() {}

	/**
	 * @param string|Ints $value
	 * @return Ints
	 * @throws DataType\InvalidArgumentsException
	 */
	public static function fromString($value)
	{
		if (is_int($value)) {
			return $value;
		}

		if (is_numeric($value) && $value == intval($value)) {
			return intval($value);
		}
		$out = preg_replace('~\s~', '', $value);
		$int = intval($out);
		if ($out != $int) {
			throw new DataType\InvalidArgumentsException('Input value is not integer. ' . $out);
		}

		return $int;
	}

}
