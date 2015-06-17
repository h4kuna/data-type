<?php

namespace h4kuna\DataType\Basic;

use h4kuna\DataType;

/**
 * @author Milan Matějček
 */
final class Arrays
{

	private function __construct() {}

	/**
	 * Better array_combine where values array does not need same size.
	 * @param array $keys
	 * @param array $values
	 * @param mixed $value
	 * @return array
	 * @throws DataType\InvalidArgumentsException
	 */
	static function combine(array $keys, array $values, $value = NULL)
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
	 * @param string $keys
	 * @return string
	 */
	static function concatWs($glue, $array /* , ... keys */)
	{
		$keys = array();
		if (func_num_args() > 2) {
			$keys = array_slice(func_get_args(), 2);
		}
		$out = '';
		foreach ($keys ? self::intesectKeys($array, $keys) : $array as $value) {
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
	 * @return string|NULL
	 */
	static function coalesce($array /* , $keys, ... */)
	{
		if (func_num_args() > 1) {
			$keys = array_slice(func_get_args(), 1);
			$array = self::intesectKeys($array, $keys);
		}
		foreach ($array as $v) {
			if (strlen($v)) {
				return $v;
			}
		}
		return NULL;
	}

	/**
	 * Unset keys from array.
	 * @param array $array
	 * @param string $key
	 * @return array Removed keys
	 */
	static function keysUnset(array & $array, $key /* , ... keys */)
	{
		$out = array();
		$args = array_slice(func_get_args(), 1);
		foreach ($args as $key) {
			if (array_key_exists($key, $array)) {
				$out[$key] = $array[$key];
				unset($array[$key]);
			}
		}
		return $out;
	}

	public static function intesectKeys(array $values, array $keys)
	{
		return array_intersect_key($values, array_flip($keys));
	}

	/**
	 * @see http://php.net/manual/en/function.array-column.php
	 * @param array $array
	 * @param string $columnName
	 * @param string $key
	 * @return array
	 */
	static function column($array, $columnName = NULL, $key = NULL)
	{
		if (PHP_VERSION_ID >= 50500) {
			return array_column($array, $columnName, $key);
		} elseif ($key === NULL && $key === $columnName) {
			return $array;
		}
		$out = array();
		if ($columnName !== NULL && $key !== NULL) {
			foreach ($array as $v) {
				$out[$v[$key]] = $v[$columnName];
			}
		} elseif ($columnName !== NULL) {
			foreach ($array as $v) {
				$out[] = $v[$columnName];
			}
		} else {
			foreach ($array as $v) {
				$out[$v[$key]] = $v;
			}
		}
		return $out;
	}

}
