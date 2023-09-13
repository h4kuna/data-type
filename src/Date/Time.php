<?php declare(strict_types=1);

namespace h4kuna\DataType\Date;

use DateTime;
use DateTimeImmutable;
use Nette\StaticClass;

final class Time
{
	use StaticClass;

	/**
	 * @return ($dateTime is DateTimeImmutable ? DateTimeImmutable : DateTime)
	 */
	public static function set(
		DateTime|DateTimeImmutable $dateTime,
		?int $hour = null,
		?int $minutes = null,
		?int $seconds = null,
		?int $microseconds = 0
	): DateTime|DateTimeImmutable
	{
		return $dateTime->setTime(
			$hour ?? (int) $dateTime->format('G'),
			$minutes ?? (int) $dateTime->format('i'),
			$seconds ?? (int) $dateTime->format('s'),
			$microseconds ?? (int) $dateTime->format('u'),
		);
	}
}
