<?php

namespace h4kuna\DataType\Basic;

use h4kuna\DataType;

/**
 * @author Milan Matějček
 */
final class Arrays
{

	private function __construct() { }

	/**
	 * Better array_combine where values array does not need same size.
	 * @param array $keys
	 * @param array $values
	 * @param mixed $value
	 * @return array
	 * @throws DataType\InvalidArgumentsException
	 */
	public static function combine(array $keys, array $values, $value = null)
	{
		$diff = count($keys) - count($values);

		if ($diff > 0) {
			$values = array_merge($values, array_fill(0, $diff, $value));
		} elseif ($diff < 0) {
			throw new DataType\InvalidArgumentsException('Array of values can\'t be bigger than keys.');
		}

		return array_combine($keys, $values);
	}

	/**
	 * Implode only values where strlen > 0 and you can define keys.
	 * @param string $glue
	 * @param array $array
	 * @param string[] $keys
	 * @return string
	 */
	public static function concatWs($glue, $array, ...$keys)
	{
		$out = '';
		foreach ($keys ? self::intersectKeys($array, $keys) : $array as $value) {
			if (!strlen($value)) {
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
	 * @param array $array
	 * @param string[] $keys
	 * @return string|null
	 */
	public static function coalesce($array, ...$keys)
	{
		if ($keys !== []) {
			$array = self::intersectKeys($array, $keys);
		}
		foreach ($array as $v) {
			if (!empty($v)) {
				return $v;
			}
		}
		return null;
	}

	/**
	 * Unset keys from array.
	 * @param array|\ArrayAccess $array
	 * @param string[] $keys
	 * @return array Removed keys
	 */
	public static function keysUnset(& $array, ...$keys)
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

	public static function intersectKeys(array $values, array $keys)
	{
		return array_intersect_key($values, array_flip($keys));
	}

}
