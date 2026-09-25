<?php declare(strict_types = 1);

namespace h4kuna\DataType\Basic;

use h4kuna\DataType\Exceptions\InvalidArgumentsException;
use h4kuna\DataType\Exceptions\InvalidTypeException;
use h4kuna\DataType\Location\Gps;
use Nette\StaticClass;
use function is_float;
use function is_int;
use function is_null;
use function is_string;
use function mb_strlen;
use function mb_substr;
use function preg_quote;
use function preg_replace;
use function preg_replace_callback;
use function sprintf;
use function str_starts_with;
use function strtolower;
use function strtoupper;
use function strtr;
use function ucfirst;
use const STR_PAD_BOTH;
use const STR_PAD_LEFT;
use const STR_PAD_RIGHT;

final class Strings
{

	use StaticClass;

	/**
	 * @throws InvalidTypeException
	 */
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

	/**
	 * @throws InvalidTypeException
	 */
	public static function toFloat(string $value): float
	{
		return Floats::from($value);
	}

	public static function startWith(
		string $haystack,
		string ...$needle,
	): bool
	{
		foreach ($needle as $str) {
			if (str_starts_with($haystack, $str)) {
				return true;
			}
		}

		return false;
	}

	/**
	 * @throws InvalidTypeException
	 */
	public static function from(mixed $value): string
	{
		if (is_int($value) || is_float($value) || is_null($value)) {
			return (string) $value;
		} elseif (is_string($value) === false) {
			throw InvalidTypeException::createInvalidString($value);
		}

		return $value;
	}

	/**
	 * @throws InvalidTypeException
	 */
	public static function toInt(string $value): int
	{
		return Integer::from($value);
	}

	/**
	 * @return array{lat: float, long: float}
	 *
	 * @throws InvalidArgumentsException
	 */
	public static function toGps(string $value): array
	{
		return Gps::fromString($value);
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
	 * @param non-empty-string $delimiter
	 * @return array<string>
	 *
	 * @deprecated use Arrays::explode()
	 */
	public static function split(
		string $value,
		string $delimiter = ', ',
	): array
	{
		return Arrays::explode($value, $delimiter);
	}

	/**
	 * @param array<scalar|null> $array
	 *
	 * @deprecated use Arrays::join()
	 */
	public static function join(
		array $array,
		string $delimiter = ', ',
	): string
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

	public static function padIfNeed(
		string $string,
		string $padString = '/',
		int $padType = STR_PAD_LEFT,
	): string
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
