<?php declare(strict_types=1);

namespace h4kuna\DataType\Date;

use DateInterval;
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
}
