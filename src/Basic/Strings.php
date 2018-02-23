<?php

namespace h4kuna\DataType\Basic;

use h4kuna\DataType\Location;

/**
 * @author Milan Matějček
 */
final class Strings
{

	private function __constructor() { }

	/**
	 * @param string $value
	 * @return float
	 */
	public static function toFloat($value)
	{
		return Floats::fromString($value);
	}

	/**
	 * @param string $value
	 * @return int
	 */
	public static function toInt($value)
	{
		return Ints::fromString($value);
	}

	/**
	 * @param string $value
	 * @return float[]
	 */
	public static function toGps($value)
	{
		return Location\Gps::fromString($value);
	}

	/**
	 * @param string $value
	 * @return array
	 */
	public static function toSet($value)
	{
		return Set::fromString($value);
	}

	/**
	 * foo_bar => fooBar
	 * @param string $string
	 * @return string
	 */
	public static function toCamel($string)
	{
		return preg_replace_callback('/_([a-z])/', 'camelCallback', $string);
	}

	/**
	 * foo_bar => FooBar
	 * @param string $string
	 * @return string
	 */
	public static function toPascal($string)
	{
		return ucfirst(self::toCamel($string));
	}

	/**
	 * FooBar => foo_bar
	 * @param string $string
	 * @return string
	 */
	public static function toUnderscore($string)
	{
		return strtolower(preg_replace_callback('/(.)([A-Z][a-z])|([a-z])([A-Z])/', 'underscoreCallback', $string));
	}

}
