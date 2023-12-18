<?php declare(strict_types=1);

namespace h4kuna\DataType\Date;

use DateTimeInterface;
use h4kuna\DataType\Basic\Strings;
use Nette\StaticClass;

final class Time
{
	use StaticClass;

	public static function micro(): float
	{
		return microtime(true);
	}


	/**
	 * string format HH:MM[:SS]
	 */
	public static function only(string|DateTimeInterface $dateTime): int
	{
		if (is_string($dateTime)) {
			$time = Strings::split($dateTime, ':');
			$hour = $time[0] ?? 0;
			$minute = $time[1] ?? 0;
			$second = $time[2] ?? 0;
		} else {
			$hour = $dateTime->format('G');
			$minute = $dateTime->format('i');
			$second = $dateTime->format('s');
		}

		return ((int) $hour) * 3600
			+ ((int) $minute) * 60
			+ ((int) $second);
	}


	public static function time(
		DateTimeInterface $dateTime,
		?int $hour = null,
		?int $minutes = null,
		?int $seconds = null,
		?int $microseconds = null,
	): DateTimeInterface
	{
		return $dateTime->setTime(
			$hour ?? (int) $dateTime->format('G'),
			$minutes ?? (int) $dateTime->format('i'),
			$seconds ?? (int) $dateTime->format('s'),
			$microseconds ?? (int) $dateTime->format('u'),
		);
	}


	public static function date(
		DateTimeInterface $dateTime,
		?int $year = null,
		?int $month = null,
		?int $day = null,
	): DateTimeInterface
	{
		return $dateTime->setDate(
			$year ?? (int) $dateTime->format('Y'),
			$month ?? (int) $dateTime->format('n'),
			$day ?? (int) $dateTime->format('j'),
		);
	}
}
