<?php declare(strict_types=1);

namespace h4kuna\DataType\Date;

use DateTime;
use DateTimeImmutable;
use Nette\StaticClass;

final class Time
{
	use StaticClass;

	public static function micro(): float
	{
		return microtime(true);
	}


	/**
	 * @return ($dateTime is DateTimeImmutable ? DateTimeImmutable : DateTime)
	 */
	public static function time(
		DateTime|DateTimeImmutable $dateTime,
		?int $hour = null,
		?int $minutes = null,
		?int $seconds = null,
		?int $microseconds = null,
	): DateTime|DateTimeImmutable
	{
		return $dateTime->setTime(
			$hour ?? (int) $dateTime->format('G'),
			$minutes ?? (int) $dateTime->format('i'),
			$seconds ?? (int) $dateTime->format('s'),
			$microseconds ?? (int) $dateTime->format('u'),
		);
	}


	/**
	 * @return ($dateTime is DateTimeImmutable ? DateTimeImmutable : DateTime)
	 */
	public static function date(
		DateTime|DateTimeImmutable $dateTime,
		?int $year = null,
		?int $month = null,
		?int $day = null,
	): DateTime|DateTimeImmutable
	{
		return $dateTime->setDate(
			$year ?? (int) $dateTime->format('Y'),
			$month ?? (int) $dateTime->format('n'),
			$day ?? (int) $dateTime->format('j'),
		);
	}
}
