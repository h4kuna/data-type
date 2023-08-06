<?php declare(strict_types=1);

namespace h4kuna\DataType\Exceptions;

final class InvalidTypeException extends DataTypeException
{

	public function __construct(string $name, string $type)
	{
		parent::__construct(sprintf('The value "%s" is not valid %s.', $name, $type));
	}


	public static function invalidInt(mixed $name): self
	{
		return new self(self::toString($name), 'int');
	}


	public static function invalidString(mixed $name): self
	{
		return new self(self::toString($name), 'string');
	}


	public static function invalidFloat(mixed $name): self
	{
		return new self(self::toString($name), 'float');
	}


	public static function invalidBool(mixed $name): self
	{
		return new self(self::toString($name), 'bool');
	}


	public static function invalidArray(mixed $name): self
	{
		return new self(self::toString($name), 'array');
	}


	private static function toString(mixed $name): string
	{
		if ($name === null) {
			return 'null';
		}

		return is_scalar($name) ? (string) $name : gettype($name);
	}

}
