<?php declare(strict_types = 1);

namespace h4kuna\DataType\Exceptions;

use function sprintf;

/**
 * Input data can not be processed.
 */
final class InvalidArgumentsException extends DataTypeException
{

	public static function createUnsupportedCoordinate(string $value): self
	{
		return new self(sprintf('Unsupported coordinate "%s".', $value));
	}

	public static function createUnsupportedPole(string $pole): self
	{
		return new self(sprintf('Unsupported pole "%s".', $pole));
	}

	public static function createCoordinateOutOfRange(float $num): self
	{
		return new self(sprintf('Coordinate can\'t be higher than 180, %s given.', $num));
	}

	public static function createDayIsNotNumeric(): self
	{
		return new self('Day is allowed as DateTimeInterface or numeric.');
	}

	public static function createDayOutOfRange(int $day): self
	{
		return new self(sprintf('Invalid number for day %d, interval is 0-7, 0 or 7 is Sunday.', $day));
	}

	public static function createMonthIsNotNumeric(): self
	{
		return new self('Month is allowed as DateTimeInterface or numeric.');
	}

	public static function createMonthOutOfRange(int $month): self
	{
		return new self(sprintf('Invalid number for month %d, interval is 1-12.', $month));
	}

	public static function createBadCzechDateFormat(string $date): self
	{
		return new self(sprintf('Bad czech date format "%s".', $date));
	}

	public static function createUnknownNameDay(
		int $month,
		int $day,
	): self
	{
		return new self(sprintf('Unknown name day for month "%d" and day "%d".', $month, $day));
	}

	public static function createUnknownDateFormat(string $any): self
	{
		return new self(sprintf('Unknown date format "%s".', $any));
	}

}
