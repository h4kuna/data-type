<?php declare(strict_types=1);

namespace h4kuna\DataType\Basic;

use h4kuna\DataType;

final class Arrays
{

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


	/**
	 * Implode only values where strlen > 0 and you can define keys.
	 * @param array<string|int, scalar|null> $array
	 */
	public static function concatWs(string $glue, array $array): string
	{
		return implode($glue, array_filter($array, fn ($v): bool => $v !== false && $v !== '' && $v !== null));
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
	 * @deprecated use unsetKeys()
	 * @param array<mixed> $array
	 * @param string|int $keys
	 * @return array<mixed>
	 */
	public static function keysUnset(&$array, ...$keys): array
	{
		return self::unsetKeys($array, ...$keys);
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

}
