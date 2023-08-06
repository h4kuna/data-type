<?php declare(strict_types=1);

namespace h4kuna\DataType\Basic;

use h4kuna\DataType\Exceptions\InvalidTypeException;

final class Bools
{

	public static function from(mixed $value): bool
	{
		if ($value === true) {
			return true;
		} elseif ($value === '' || $value === null || $value === false) {
			return false;
		} elseif (is_numeric($value)) {
			return match ((float) $value) {
				1.0 => true,
				0.0 => false,
				default => throw InvalidTypeException::invalidBool($value),
			};
		}
		throw InvalidTypeException::invalidBool($value);
	}

}
