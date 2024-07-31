<?php declare(strict_types=1);

namespace h4kuna\DataType\Basic;

use h4kuna\DataType;
use h4kuna\DataType\Exceptions\InvalidTypeException;
use Nette\StaticClass;

final class Integer
{
	use StaticClass;

	public static function nullable(mixed $value): ?int
	{
		return $value === null ? null : self::from($value);
	}


	public static function from(mixed $value): int
	{
		if (is_bool($value) || is_int($value) || $value === null || $value === '' || (is_numeric($value) && $value == (int) $value)) {
			return (int) $value;
		}

		throw InvalidTypeException::invalidInt($value);
	}

}
