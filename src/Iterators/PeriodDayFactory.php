<?php declare(strict_types=1);

namespace h4kuna\DataType\Iterators;

use DateInterval;
use DatePeriod;
use DateTime;
use DateTimeImmutable;
use h4kuna\DataType\Date\Convert;

final class PeriodDayFactory
{

	/**
	 * interval is (from, to> | exclude from, include to
	 */
	public static function createExFromInTo(
		DateTimeImmutable|DateTime $start,
		DateTimeImmutable|DateTime $end,
	): DatePeriod
	{
		return new DatePeriod(
			Convert::toImmutableMidnight($start),
			self::createDayInterval(),
			Convert::toImmutable($end)->modify('+1 day, midnight'),
			DatePeriod::EXCLUDE_START_DATE
		);
	}


	/**
	 * interval is <from, to> | exclude from, include to
	 */
	public static function createInFromInTo(
		DateTimeImmutable|DateTime $start,
		DateTimeImmutable|DateTime $end,
	): DatePeriod
	{
		return new DatePeriod(
			Convert::toImmutableMidnight($start),
			self::createDayInterval(),
			Convert::toImmutable($end)->modify('+1 day, midnight')
		);
	}


	/**
	 * interval is (from, to) | exclude from, include to
	 */
	public static function createExFromExTo(
		DateTimeImmutable|DateTime $start,
		DateTimeImmutable|DateTime $end,
	): DatePeriod
	{
		return new DatePeriod(
			Convert::toImmutableMidnight($start),
			self::createDayInterval(),
			Convert::toImmutableMidnight($end),
			DatePeriod::EXCLUDE_START_DATE
		);
	}


	/**
	 * interval is <from, to) | exclude from, include to
	 */
	public static function createInFromExTo(
		DateTimeImmutable|DateTime $start,
		DateTimeImmutable|DateTime $end,
	): DatePeriod
	{
		return new DatePeriod(
			Convert::toImmutableMidnight($start),
			self::createDayInterval(),
			Convert::toImmutableMidnight($end)
		);
	}


	private static function createDayInterval(): DateInterval
	{
		return new DateInterval('P1D');
	}

}
