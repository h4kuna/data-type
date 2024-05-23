<?php declare(strict_types=1);

namespace h4kuna\DataType\Date;

use DateInterval;
use DateTimeInterface;
use h4kuna\DataType\Number\Math;
use Nette\Utils\DateTime;

final class Interval
{
	public static function toSeconds(DateInterval $dateInterval): int
	{
		return ((int) $dateInterval->days) * DateTime::DAY
			+ $dateInterval->h * DateTime::HOUR
			+ $dateInterval->i * DateTime::MINUTE
			+ $dateInterval->s;
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
