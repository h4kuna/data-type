<?php declare(strict_types = 1);

namespace h4kuna\DataType\Date;

final class Duration
{

	public const Second = 1;
	public const Minute = self::Second * 60;
	public const Hour = self::Minute * 60;
	public const Day = self::Hour * 24;
	public const Week = self::Day * 7;

	/** average month in seconds */
	public const Month = 2_629_800;

	/** average year in seconds */
	public const Year = 31_557_600;

}
