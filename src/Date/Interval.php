<?php declare(strict_types = 1);

namespace h4kuna\DataType\Date;

use DateInterval;
use DateTimeInterface;
use h4kuna\DataType\Number\Math;
use Nette\Utils\DateTime;
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
			$days = $dateInterval->y * DateTime::YEAR
				+ $dateInterval->m * DateTime::MONTH
				+ $dateInterval->d * DateTime::DAY;
		} else {
			$days = $dateInterval->days * DateTime::DAY;
		}

		$days += $dateInterval->h * DateTime::HOUR
			+ $dateInterval->i * DateTime::MINUTE
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
