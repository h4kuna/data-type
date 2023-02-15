<?php declare(strict_types=1);

namespace h4kuna\DataType\Basic;

use h4kuna\DataType;

final class Ints
{

	/**
	 * @throws DataType\Exceptions\InvalidArgumentsException
	 */
	public static function fromString(string|int $value): int
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
			throw new DataType\Exceptions\InvalidArgumentsException('Input value is not integer. ' . $out);
		}

		return $int;
	}

}
