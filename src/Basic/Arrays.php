<?php declare(strict_types=1);

namespace h4kuna\DataType\Basic;

use h4kuna\DataType;
use Nette\StaticClass;
use Nette\Utils\Strings;
use Stringable;

final class Arrays
{
	use StaticClass;

	/**
	 * Better array_combine where values array does not need same size.
	 * @param array<string|int> $keys
	 * @param array<mixed> $values
	 * @return array<string|int, mixed>
	 */
	public static function combine(array $keys, array $values, mixed $value = null): array
	{
		$diff = count($keys) - count($values);

		if ($diff > 0) {
			$values = array_merge($values, array_fill(0, $diff, $value));
		} elseif ($diff < 0) {
			throw new DataType\Exceptions\InvalidArgumentsException('Array of values can\'t be bigger than keys.');
		}

		return array_combine($keys, $values);
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


	/**
	 * strict in_array
	 * @param list<mixed>|array<string|int, mixed> $haystack
	 */
	public static function contains(string $needle, array $haystack): bool
	{
		return in_array($needle, $haystack, true);
	}


	/**
	 * @param array<scalar|Stringable|null> $array
	 * @deprecated use join
	 * Implode only values where strlen > 0 and you can define keys.
	 */
	public static function concatWs(string $glue, array $array): string
	{
		return self::join($array, $glue);
	}


	/**
	 * The original implode/join(',', ['', null, false, 'A']) return ',,,A' right is 'A'.
	 * @param array<scalar|Stringable|null> $array
	 */
	public static function join(array $array, string $delimiter = ','): string
	{
		return implode(
			$delimiter,
			array_filter($array, static fn (mixed $value): bool => $value !== false && $value !== '' && $value !== null)
		);
	}


	/**
	 * The original explode(',', '') return [''] right is [].
	 * @param non-empty-string $delimiter
	 *
	 * @return array<string>
	 */
	public static function explode(string $value, string $delimiter = ',', ?int $limit = null): array
	{
		if ($value === '') {
			return [];
		}

		return $limit === null
			? explode($delimiter, $value)
			: explode($delimiter, $delimiter, $limit);
	}


	/**
	 * COALESCE similar behavior database.
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
	 * @param array<mixed> $array
	 * @param string|int $keys
	 * @return array<mixed>
	 */
	public static function unsetKeys(&$array, ...$keys): array
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
	 * @template T
	 * @param array<string|int, T> $values
	 * @param array<string|int> $keys
	 * @return array<string|int, T>
	 */
	public static function intersectKeys(array $values, array $keys): array
	{
		return array_intersect_key($values, array_flip($keys));
	}


	/**
	 * @return array<int>
	 */
	public static function generateNumbers(int $from, int $to): array
	{
		$values = range($from, $to, ($from < $to) ? 1 : -1);

		return array_combine($values, $values);
	}


	/**
	 * @param array<mixed> $array1
	 * @param array<mixed> $array2
	 * @param array<mixed> ...$arrays
	 * @return array<mixed>
	 */
	public static function mergeUnique(array $array1, array $array2, array ...$arrays): array
	{
		return array_values(array_unique(array_merge($array1, $array2, ...$arrays)));
	}


	/**
	 * @return array<string>
	 */
	public static function text2Array(string $text): array
	{
		$existsNewMethod = method_exists(Strings::class, 'unixNewLines'); // @phpstan-ignore-line
		return explode("\n", $existsNewMethod
			? Strings::unixNewLines($text)
			: Strings::normalizeNewLines($text)
		);
	}

}
