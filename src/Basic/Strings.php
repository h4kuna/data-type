<?php declare(strict_types=1);

namespace h4kuna\DataType\Basic;

use h4kuna\DataType\Exceptions\InvalidStateException;
use h4kuna\DataType\Exceptions\InvalidTypeException;
use h4kuna\DataType\Location;

final class Strings
{
	public static function from(mixed $value): string
	{
		if (is_int($value) || is_float($value) || is_null($value)) {
			return (string) $value;
		} elseif (is_string($value) === false) {
			throw InvalidTypeException::invalidString($value);
		}

		return $value;
	}


	public static function strokeToPoint(string $value): string
	{
		return strtr($value, [',' => '.']);
	}


	public static function toFloat(string $value): float
	{
		return Floats::from($value);
	}


	public static function toInt(string $value): int
	{
		return Integer::from($value);
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
	 * The original explode(',', '') return [''] right is [].
	 *
	 * @return array<string>
	 */
	public static function split(string $value, string $delimiter = ', '): array
	{
		if ($delimiter === '') {
			throw new InvalidStateException('Delimiter like empty string is not allowed.');
		} elseif ($value === '') {
			return [];
		}

		return explode($delimiter, $value);
	}


	/**
	 * The original implode/join(',', ['', null, false, 'A']) return ',,,A' right is 'A'.
	 * @param array<scalar|null> $array
	 */
	public static function join(array $array, string $delimiter = ', '): string
	{
		return implode(
			$delimiter,
			array_filter($array, static fn (mixed $value): bool => $value !== false && $value !== '' && $value !== null)
		);
	}


	public static function padIfNeed(string $string, string $padString = '/', int $padType = STR_PAD_LEFT): string
	{
		$length = mb_strlen($padString);
		$prefix = $suffix = '';
		if (($padType === STR_PAD_LEFT || $padType === STR_PAD_BOTH) && mb_substr($string, 0, $length) !== $padString) {
			$prefix = $padString;
		}

		if (($padType === STR_PAD_RIGHT || $padType === STR_PAD_BOTH) && mb_substr($string, -$length) !== $padString) {
			$suffix = $padString;
		}

		return "$prefix$string$suffix";
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
