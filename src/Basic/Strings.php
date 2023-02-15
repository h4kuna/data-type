<?php declare(strict_types=1);

namespace h4kuna\DataType\Basic;

use h4kuna\DataType\Location;

final class Strings
{

	public static function toFloat(string $value): float
	{
		return Floats::fromString($value);
	}


	public static function toInt(string $value): int
	{
		return Ints::fromString($value);
	}


	/**
	 * @return array{lat: float, long: float}
	 */
	public static function toGps(string $value): array
	{
		return Location\Gps::fromString($value);
	}


	/**
	 * @return array<string, true>
	 */
	public static function toSet(string $value): array
	{
		return Set::fromString($value);
	}


	/**
	 * foo_bar => fooBar
	 */
	public static function toCamel(string $string): string
	{
		return (string) preg_replace_callback('/_([a-z])/', static function (array $find): string {
			return strtoupper($find[1]);
		}, $string);
	}


	/**
	 * foo_bar => FooBar
	 */
	public static function toPascal(string $string): string
	{
		return ucfirst(self::toCamel($string));
	}


	/**
	 * FooBar => foo_bar
	 */
	public static function toUnderscore(string $string): string
	{
		return strtolower((string) preg_replace_callback('/(.)([A-Z][a-z])|([a-z])([A-Z])/', static function (
			array $find,
		): string {
			if (isset($find[1]) && $find[1] !== '') {
				return $find[1] . '_' . $find[2];
			}

			return $find[3] . '_' . $find[4];
		}, $string));
	}

}
