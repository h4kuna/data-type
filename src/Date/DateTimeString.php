<?php

namespace h4kuna\DataType\Date;

class DateTimeString
{

	const TWO_DIGIT = '(?P<%s>\d{1,2})';
	const FOUR_DIGIT = '(?P<%s>\d{4})';
	const P_STRING = '\w+';
	const P_INT = '\d+';
	const P_MARK = '(?:\+|-)?';

	/** @var array temp */
	private static $map;

	/** @var int temp */
	private static $yearShort;

	private static $class = \DateTime::class;

	/** @var bool */
	private static $freeze = false;

	public static function setClass($class)
	{
		if (self::$freeze) {
			throw new \RuntimeException('You can change class before use and onetime per lifecycle.');
		} elseif (!is_string($class) || (!is_a($class, \DateTime::class, true) && !is_a($class, \DateTimeImmutable::class, true))) {
			throw new \InvalidArgumentException('Class must be string and extends php class \\Datetime or \\DatetimeImmutable.');
		}
		self::$class = ltrim($class, '\\');
		self::$freeze = true;
	}

	/**
	 * @param string $format
	 * @param string $date
	 * @param \DateTimeZone|null $timezone
	 * @return \DateTimeInterface|null
	 */
	public static function from($format, $date, \DateTimeZone $timezone = null)
	{
		self::$freeze = true;
		$quote = preg_quote($format);
		$pattern = strtr($quote, self::getMap());
		if ($pattern !== $quote && (!self::validPattern($pattern) || !preg_match('~^' . $pattern . '$~', $date, $find) || !checkdate($find['month'], $find['day'], self::transformYear($find)))) {
			return null;
		}

		$class = self::$class;
		if ($timezone === null) {
			$dt = $class::createFromFormat($format, $date);
		} else {
			$dt = $class::createFromFormat($format, $date, $timezone);
		}

		if (!$dt) {
			return null;
		} elseif (self::resetTime($format)) {
			$dt->modify('midnight');
		}

		return self::toOriginalDateTime($dt);
	}

	private static function validPattern($pattern)
	{
		$out = [
			'day' => 0,
			'month' => 0,
			'year' => 0,
		];
		preg_replace_callback('~\<(day|month|year)(?:_short)?\>~', function ($find) use (&$out) {
			++$out[$find[1]];
		}, $pattern);

		if ($out['day'] === 1 && $out['month'] === 1 && $out['year'] === 1) {
			return true;
		}
		// prepare exception
		$missing = $much = [];
		foreach ($out as $key => $item) {
			if ($item === 0) {
				$missing[] = $key;
			} elseif ($item > 1) {
				$much[] = $key;
			}
		}
		$error = '';
		if ($missing) {
			$error .= 'These arguments missing: ' . implode(', ', $missing) . '. ';
		}
		if ($much) {
			$error .= 'These arguments too much: ' . implode(', ', $much) . '.';
		}
		throw new \InvalidArgumentException(trim($error));
	}

	private static function resetTime($format)
	{
		return !preg_match('~[gGhHisuv]~', $format);
	}

	private static function getMap()
	{
		if (self::$map !== null) {
			return self::$map;
		}

		self::$map = [
			// sort by http://php.net/manual/en/function.date.php
			// day
			'd' => sprintf(self::TWO_DIGIT, 'day'),
			'D' => self::P_STRING,
			'j' => sprintf(self::TWO_DIGIT, 'day'),
			'l' => self::P_STRING,
			'N' => self::P_INT,
			'S' => self::P_STRING,
			'w' => self::P_INT,
			'z' => self::P_INT,
			// week
			'W' => self::P_INT . self::P_STRING,
			// month
			'F' => self::P_STRING,
			'm' => sprintf(self::TWO_DIGIT, 'month'),
			'M' => self::P_STRING,
			'n' => sprintf(self::TWO_DIGIT, 'month'),
			't' => self::P_INT,
			// year
			'L' => self::P_INT,
			'o' => sprintf(self::FOUR_DIGIT, 'year'),
			'Y' => sprintf(self::FOUR_DIGIT, 'year'),
			'y' => sprintf(self::TWO_DIGIT, 'year_short'),
			// time
			'a' => self::P_STRING,
			'A' => self::P_STRING,
			'B' => '\d{0,3}',
			'g' => '\d{1,2}',
			'G' => '\d{1,2}',
			'h' => '\d{1,2}',
			'H' => '\d{1,2}',
			'i' => '\d{1,2}',
			's' => '\d{1,2}',
			'u' => '\d{1,6}',
			'v' => '\d{1,6}',
			// timezone
			'e' => self::P_STRING,
			'I' => self::P_INT,
			'O' => self::P_MARK . self::P_INT,
			'P' => self::P_MARK . '\d{2}:\d{2}',
			'T' => self::P_STRING,
			'Z' => self::P_MARK . self::P_INT,
			// full datetime not supported
		];

		return self::$map;
	}

	private static function transformYear($find)
	{
		if (isset($find['year_short'])) {
			return $find['year_short'] + self::yearShortConst();
		}
		return $find['year'];
	}

	private static function yearShortConst()
	{
		if (self::$yearShort === null) {
			self::$yearShort = round(date('Y'), -2);
		}
		return self::$yearShort;
	}

	private static function toOriginalDateTime(\DateTimeInterface $datetime)
	{
		$class = self::$class;
		if ($class === get_class($datetime)) {
			return $datetime;
		}

		return new $class($datetime->format('Y-m-d H:i:s.u'), $datetime->getTimezone());
	}
}