<?php

namespace h4kuna\DataType\Date;

use Nette\Utils;

class DatePeriod extends \DatePeriod
{

	const INCLUDE_END_DATE = 4;

	/**
	 * @param string|int|\DateTimeInterface $from
	 * @param string|int|\DateTimeInterface $to
	 * @param string|\DateInterval $interval
	 * @param int $options
	 * @return static
	 */
	public static function create($from, $to, $interval = null, $options = self::INCLUDE_END_DATE)
	{
		$intervalInstance = self::createInterval($interval === null ? '1 day' : $interval);
		$endDate = self::createDateTime($to);
		if ($options & self::INCLUDE_END_DATE) {
			$endDate = clone $endDate;
			$endDate->modify('+1 second');
		}

		return new static(self::createDateTime($from), $intervalInstance, $endDate, $options);
	}

	private static function createDateTime($date)
	{
		if ($date instanceof \DateTimeInterface) {
			return $date;
		}
		return Utils\DateTime::from($date);
	}

	private static function createInterval($interval)
	{
		if ($interval instanceof \DateInterval) {
			return $interval;
		} elseif (substr($interval, 0, 1) === 'P') {
			return new \DateInterval($interval);
		}
		return \DateInterval::createFromDateString($interval);
	}
}