<?php declare(strict_types = 1);

namespace h4kuna\DataType\Basic;

use h4kuna\DataType\Basic\Strings as MyStrings;
use h4kuna\DataType\Exceptions\LogicException;
use Nette\StaticClass;
use Nette\Utils\Strings;
use Stringable;
use function array_combine;
use function array_fill;
use function array_filter;
use function array_flip;
use function array_intersect_key;
use function array_key_exists;
use function array_merge;
use function array_unique;
use function array_values;
use function count;
use function explode;
use function implode;
use function in_array;
use function method_exists;
use function range;

final class Arrays
{

	use StaticClass;

	/**
	 * @param array<TKey> $keys
	 * @param array<TValue> $values
	 * @param TDefault $value
	 * @return array<TKey, TValue|TDefault>
	 *
	 * @template TKey of array-key
	 * @template TValue
	 * @template TDefault
	 *
	 * Better array_combine where values array does not need same size.
	 */
	public static function combine(
		array $keys,
		array $values,
		mixed $value = null,
	): array
	{
		$diff = count($keys) - count($values);

		if ($diff > 0) {
			$values = array_merge($values, array_fill(0, $diff, $value));
		} elseif ($diff < 0) {
			throw new LogicException('Array of values can\'t be bigger than keys.');
		}

		return array_combine($keys, $values);
	}

	/**
	 * @deprecated use \h4kuna\DataType\Basic\Strings::startsWith
	 */
	public static function startWith(
		string $haystack,
		string ...$needle,
	): bool
	{
		return MyStrings::startWith($haystack, ...$needle);
	}

	/**
	 * strict in_array
	 *
	 * @param list<mixed>|array<mixed> $haystack
	 */
	public static function contains(
		string $needle,
		array $haystack,
	): bool
	{
		return in_array($needle, $haystack, true);
	}

	/**
	 * @param array<scalar|Stringable|null> $array
	 *
	 * @deprecated use join
	 * Implode only values where strlen > 0 and you can define keys.
	 */
	public static function concatWs(
		string $glue,
		array $array,
	): string
	{
		return self::join($array, $glue);
	}

	/**
	 * The original implode/join(',', ['', null, false, 'A']) return ',,,A' right is 'A'.
	 *
	 * @param array<scalar|Stringable|null> $array
	 */
	public static function join(
		array $array,
		string $delimiter = ',',
	): string
	{
		return implode($delimiter, self::filter($array));
	}

	/**
	 * The original explode(',', '') return [''] right is [].
	 *
	 * @param non-empty-string $delimiter
	 * @return array<string>
	 */
	public static function explode(
		string $value,
		string $delimiter = ',',
		?int $limit = null,
	): array
	{
		if ($value === '') {
			return [];
		}

		return $limit === null
			? explode($delimiter, $value)
			: explode($delimiter, $value, $limit);
	}

	/**
	 * Remove false, empty string and null. Keys are preserved.
	 *
	 * @param array<TKey, TValue> $array
	 * @return array<TKey, TValue>
	 *
	 * @template TKey of array-key
	 * @template TValue
	 */
	public static function filter(array $array): array
	{
		return array_filter($array, static fn (mixed $value): bool => $value !== false && $value !== '' && $value !== null);
	}

	/**
	 * COALESCE similar behavior database.
	 *
	 * @param iterable<string|int, mixed> $array
	 */
	public static function coalesce(iterable $array): mixed
	{
		foreach ($array as $v) {
			if ($v !== null) {
				return $v;
			}
		}

		return null;
	}

	/**
	 * Unset keys from array.
	 *
	 * @param array<TValue>|list<TValue> $array
	 * @param string|int ...$keys
	 * @return ($array is list ? list<TValue> : array<TValue>)
	 *
	 * @template TValue
	 */
	public static function unsetKeys(
		&$array,
		...$keys,
	): array
	{
		$out = [];
		foreach ($keys as $key) {
			if (array_key_exists($key, $array)) {
				$out[$key] = $array[$key];
				unset($array[$key]);
			}
		}

		return $out;
	}

	/**
	 * @param array<T> $values
	 * @param array<int|string> $keys
	 * @return array<T>
	 *
	 * @template T
	 */
	public static function intersectKeys(
		array $values,
		array $keys,
	): array
	{
		return array_intersect_key($values, array_flip($keys));
	}

	/**
	 * @return array<int>
	 */
	public static function generateNumbers(
		int $from,
		int $to,
	): array
	{
		$values = range($from, $to, ($from < $to) ? 1 : -1);

		return array_combine($values, $values);
	}

	/**
	 * @param array<scalar|Stringable|null> $array1
	 * @param array<scalar|Stringable|null> $array2
	 * @param array<scalar|Stringable|null> ...$arrays
	 * @return list<scalar|Stringable|null>
	 */
	public static function mergeUnique(
		array $array1,
		array $array2,
		array ...$arrays,
	): array
	{
		return array_values(array_unique(array_merge($array1, $array2, ...$arrays)));
	}

	/**
	 * @return list<string>
	 */
	public static function text2Array(string $text): array
	{
		$existsNewMethod = method_exists(Strings::class, 'unixNewLines'); // @phpstan-ignore-line
		return explode("\n", $existsNewMethod
			? Strings::unixNewLines($text)
			: Strings::normalizeNewLines($text));
	}

}
