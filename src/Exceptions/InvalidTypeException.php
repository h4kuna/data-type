<?php declare(strict_types = 1);

namespace h4kuna\DataType\Exceptions;

use function gettype;
use function is_scalar;
use function sprintf;

/**
 * Value has not expected type.
 */
final class InvalidTypeException extends DataTypeException
{

	public static function createInvalidInt(mixed $name): self
	{
		return self::create($name, 'int');
	}

	public static function createInvalidString(mixed $name): self
	{
		return self::create($name, 'string');
	}

	public static function createInvalidFloat(mixed $name): self
	{
		return self::create($name, 'float');
	}

	public static function createInvalidBool(mixed $name): self
	{
		return self::create($name, 'bool');
	}

	public static function createInvalidArray(mixed $name): self
	{
		return self::create($name, 'array');
	}

	private static function create(
		mixed $name,
		string $type,
	): self
	{
		return new self(sprintf('The value "%s" is not valid %s.', self::toString($name), $type));
	}

	private static function toString(mixed $name): string
	{
		if ($name === null) {
			return 'null';
		}

		return is_scalar($name) ? (string) $name : gettype($name);
	}

}
