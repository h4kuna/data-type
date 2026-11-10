<?php declare(strict_types = 1);

namespace h4kuna\DataType\Date;

use DateInterval;
use DateTimeInterface;
use h4kuna\DataType\Number\Math;
use function round;

final class Interval
{

	public static function toSeconds(DateInterval $dateInterval): int
	{
		return (int) round(self::toSecondsMilli($dateInterval));
	}

	public static function toSecondsMilli(DateInterval $dateInterval): float
	{
		if ($dateInterval->days === false) {
			$days = $dateInterval->y * Duration::Year
				+ $dateInterval->m * Duration::Month
				+ $dateInterval->d * Duration::Day;
		} else {
			$days = $dateInterval->days * Duration::Day;
		}

		$days += $dateInterval->h * Duration::Hour
			+ $dateInterval->i * Duration::Minute
			+ $dateInterval->s
			+ $dateInterval->f;

		return $dateInterval->invert === 1 ? $days * -1 : $days;
	}

	/**
	 * @param T $date
	 * @param T|null $from
	 * @param T|null $to
	 * @return T
	 *
	 * @template T of DateTimeInterface
	 */
	public static function interval(
		DateTimeInterface $date,
		?DateTimeInterface $from,
		?DateTimeInterface $to = null,
	): DateTimeInterface
	{
		return Math::interval($date, $to, $from);
	}

}
