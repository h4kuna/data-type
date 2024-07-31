<?php declare(strict_types=1);

namespace h4kuna\DataType\Basic;

use h4kuna\DataType\Exceptions\InvalidTypeException;
use Nette\StaticClass;

final class Bools
{
	use StaticClass;

	public static function nullable(mixed $value): ?bool
	{
		return $value === null ? null : self::from($value);
	}


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
