<?php declare(strict_types=1);

namespace h4kuna\DataType\Date;

use DateInterval;
use DateTimeInterface;
use h4kuna\DataType\Number\Math;
use Nette\Utils;

final class Interval
{
	public static function toSeconds(DateInterval $dateInterval): int
	{
		return (int) round(self::toSecondsMilli($dateInterval));
	}

	public static function toSecondsMilli(DateInterval $dateInterval): float
	{
		if ($dateInterval->days === false) {
			$days = $dateInterval->y * Utils\DateTime::YEAR
				+ $dateInterval->m * Utils\DateTime::MONTH
				+ $dateInterval->d * Utils\DateTime::DAY;
		} else {
			$days = $dateInterval->days * Utils\DateTime::DAY;
		}

		$days += $dateInterval->h * Utils\DateTime::HOUR
			+ $dateInterval->i * Utils\DateTime::MINUTE
			+ $dateInterval->s
			+ $dateInterval->f;

		return $dateInterval->invert === 1 ? $days * -1 : $days;
	}


	/**
	 * @template T of DateTimeInterface
	 * @param T $date
	 * @param T|null $from
	 * @param T|null $to
	 *
	 * @return T
	 */
	public static function interval(
		DateTimeInterface $date,
		?DateTimeInterface $from,
		?DateTimeInterface $to = null
	): DateTimeInterface
	{
		return Math::interval($date, $to, $from);
	}
}
