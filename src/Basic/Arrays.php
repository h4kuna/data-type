<?php declare(strict_types=1);

namespace h4kuna\DataType\Basic;

use h4kuna\DataType;

final class Arrays
{

	private function __construct()
	{
	}


	/**
	 * Better array_combine where values array does not need same size.
	 * @param array<string|int> $keys
	 * @param array<mixed> $values
	 * @param mixed $value
	 * @return array<string|int, mixed>
	 * @throws \h4kuna\DataType\Exceptions\InvalidArgumentsException
	 */
	public static function combine(array $keys, array $values, $value = null)
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
	 * @param array<string|int, scalar> $array
	 * @param string|int $keys
	 * @return string
	 */
	public static function concatWs(string $glue, $array, ...$keys)
	{
		$out = '';
		foreach ($keys ? self::intersectKeys($array, $keys) : $array as $value) {
			if (strlen((string) $value) === 0) {
				continue;
			} elseif ($out !== '') {
				$out .= $glue;
			}
			$out .= $value;
		}

		return $out;
	}


	/**
	 * COALESCE similar behavior database.
	 * @param array<string|int, mixed> $array
	 * @param string|int $keys
	 * @return mixed
	 */
	public static function coalesce($array, ...$keys)
	{
		if ($keys !== []) {
			$array = self::intersectKeys($array, $keys);
		}
		foreach ($array as $v) {
			if ($v !== null && $v !== false && $v !== '') {
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
	public static function keysUnset(&$array, ...$keys): array
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

}
