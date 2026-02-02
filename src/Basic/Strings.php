<?php declare(strict_types=1);

namespace h4kuna\DataType\Basic;

use h4kuna\DataType\Exceptions\InvalidStateException;
use h4kuna\DataType\Exceptions\InvalidTypeException;
use h4kuna\DataType\Location;
use Nette\StaticClass;

final class Strings
{
	use StaticClass;

	public static function nullable(mixed $value): ?string
	{
		return $value === null ? null : self::from($value);
	}


	public static function strokeToPoint(string $value): string
	{
		return strtr($value, ',', '.');
	}


	public static function key(string|int ...$values): string
	{
		return self::join($values, "\x00");
	}


	public static function toFloat(string $value): float
	{
		return Floats::from($value);
	}

	public static function startWith(string $haystack, string ...$needle): bool
	{
		foreach ($needle as $str) {
			if (str_starts_with($haystack, $str)) {
				return true;
			}
		}

		return false;
	}


	public static function from(mixed $value): string
	{
		if (is_int($value) || is_float($value) || is_null($value)) {
			return (string) $value;
		} elseif (is_string($value) === false) {
			throw InvalidTypeException::invalidString($value);
		}

		return $value;
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
	 * foo_bar => FooBar
	 */
	public static function toPascal(string $string): string
	{
		return ucfirst(self::toCamel($string));
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
	 * @deprecated use Arrays::explode()
	 *
	 * @return array<string>
	 */
	public static function split(string $value, string $delimiter = ', '): array
	{
		return Arrays::explode($value, $delimiter);
	}


	/**
	 * @deprecated use Arrays::join()
	 *
	 * @param array<scalar|null> $array
	 */
	public static function join(array $array, string $delimiter = ', '): string
	{
		return Arrays::join($array, $delimiter);
	}


	/**
	 * FooBar => foo_bar
	 */
	public static function toUnderscore(string $string): string
	{
		return strtolower((string) preg_replace_callback('/(.)([A-Z][a-z])|([a-z])([A-Z])/', static function (
			array $find,
		): string {
			if ($find[1] !== '') {
				return $find[1] . '_' . $find[2];
			}

			return $find[3] . '_' . $find[4];
		}, $string));
	}


	public static function replaceStart(
		string $subject,
		string $search,
		string $replacement = '',
	): string
	{
		return self::strictReplace($subject, $search, $replacement, '^%s', 1);
	}


	private static function strictReplace(
		string $subject,
		string $search,
		string $replacement,
		string $pattern,
		int $limit = -1,
	): string
	{
		return preg_replace(
			sprintf(self::padIfNeed($pattern, '#', STR_PAD_BOTH), preg_quote($search, '#')),
			$replacement,
			$subject,
			$limit,
		) ?? $search;
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


	public static function replaceEnd(
		string $subject,
		string $search,
		string $replacement = '',
	): string
	{
		return self::strictReplace($subject, $search, $replacement, '%s$', 1);
	}

}
