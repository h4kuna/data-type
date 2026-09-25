<?php declare(strict_types = 1);

namespace h4kuna\DataType\Date;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Nette\StaticClass;
use function assert;

final class Convert
{

	use StaticClass;

	public static function timestampToImmutable(int $timestamp): DateTimeImmutable
	{
		return (new DateTimeImmutable())->setTimestamp($timestamp);
	}

	public static function toMutable(DateTime|DateTimeImmutable $dateTime): DateTime
	{
		return $dateTime instanceof DateTime ? clone $dateTime : DateTime::createFromImmutable($dateTime);
	}

	public static function bySource(
		DateTime|DateTimeImmutable $source,
		DateTime|DateTimeImmutable $dateTime,
	): DateTime|DateTimeImmutable
	{
		$sourceClass = $source::class;
		if ($sourceClass === $dateTime::class) {
			return $dateTime;
		}

		$result = $sourceClass::createFromFormat(DateTimeInterface::RFC3339_EXTENDED, $dateTime->format(DateTimeInterface::RFC3339_EXTENDED));
		assert($result !== false);

		return $result;
	}

	public static function toImmutableMidnight(DateTime|DateTimeImmutable $dateTime): DateTimeImmutable
	{
		return self::toImmutable($dateTime)->setTime(0, 0, 0, 0);
	}

	public static function toImmutable(DateTime|DateTimeImmutable $dateTime): DateTimeImmutable
	{
		return $dateTime instanceof DateTimeImmutable ? $dateTime : DateTimeImmutable::createFromMutable($dateTime);
	}

}
