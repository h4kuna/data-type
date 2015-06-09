<?php

namespace h4kuna\DataType\Basic;

use h4kuna\DataType\Location;

/**
 * @author Milan Matějček
 */
final class String
{

	private function __constructor()
	{

	}

	/**
	 *
	 * @param string|int|float $value
	 * @return float
	 */
	public static function toFloat($value)
	{
		return Float::fromString($value);
	}

	/**
	 *
	 * @param int|string $value
	 * @return int
	 */
	public static function toInt($value)
	{
		return Int::fromString($value);
	}

	/**
	 *
	 * @param string $value
	 * @return float[]
	 */
	public static function toGps($value)
	{
		return Location\Gps::fromString($value);
	}

	/**
	 *
	 * @param array|\Iterator|string $value
	 * @return array
	 */
	public static function toSet($value)
	{
		return Set::fromString($value);
	}

	/**
	 * Change engoding from 1250 or 8859-2 to UTF-8
	 *
	 * @param string $s
	 * @return string
	 */
	public static function autoUTF($s)
	{
		// detect UTF-8
		if (preg_match('#[\x80-\x{1FF}\x{2000}-\x{3FFF}]#u', $s))
			return $s;

		// detect WINDOWS-1250
		if (preg_match('#[\x7F-\x9F\xBC]#', $s))
			return iconv('WINDOWS-1250', 'UTF-8', $s);

		// assume ISO-8859-2
		return iconv('ISO-8859-2', 'UTF-8', $s);
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
