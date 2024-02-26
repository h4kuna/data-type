<?php declare(strict_types=1);

namespace h4kuna\DataType\Date;

use DateTime;
use DateTimeImmutable;
use h4kuna\DataType\Basic\Arrays;
use h4kuna\DataType\Exceptions\InvalidArgumentsException;
use Nette\Utils\Strings as NetteStrings;
use h4kuna\DataType\Basic\Strings;
use Nette\Utils\Validators;

final class Parser
{
	/** @var array<string> */
	public static array $formats = ['d.m. H:i', 'm-d H:i', 'd.m.Y H:i', 'Y-m-d H:i', 'd.m.Y H:i:s', 'Y-m-d H:i:s'];


	/**
	 * @param string $any
	 * @param DateTime|DateTimeImmutable|null $dateTime
	 * @return ($dateTime is DateTime ? DateTime : DateTimeImmutable)
	 */
	public static function fromString(
		string $any,
		DateTime|DateTimeImmutable|null $dateTime = null
	): DateTime|DateTimeImmutable
	{
		if ($dateTime === null) {
			$dateTime = new DateTimeImmutable();
		}

		$time = ltrim($any, '0');
		if ($time === '') {
			return $dateTime;
		}
		$dateTime = clone $dateTime;
		$prepareFloat = Strings::strokeToPoint($any);

		return match (true) {
			$any === 'now' => $dateTime instanceof DateTime ? new DateTime() : new DateTimeImmutable(),
			Validators::isNumericInt($any) => self::isModification($any) ? $dateTime->modify(sprintf('%s hour', $any)) : $dateTime->setTime((int) $any, 0),
			Validators::isNumeric($prepareFloat) => $dateTime->modify(self::modifierFromFloat((float) $prepareFloat)),
			self::isTimeFormat($any) => self::fromTimeFormat($any, $dateTime),
			default => self::fromFormat($any, $dateTime instanceof DateTime),
		};
	}


	private static function modifierFromFloat(float $value): string
	{
		return self::modifier(0, 0, (int) ($value * 3600));
	}


	private static function modifier(int $hour, int $minute, int $second = 0): string
	{
		return sprintf('%s hour, %s minute, %s second', $hour, $minute, $second);
	}


	private static function isTimeFormat(string $any): bool
	{
		return NetteStrings::match($any, '/^[+-]?\d+:\d*(:\d*)?$/') !== null;
	}


	/**
	 * @return ($date is DateTime ? DateTime : DateTimeImmutable)
	 */
	private static function fromTimeFormat(string $any, DateTime|DateTimeImmutable $date): DateTime|DateTimeImmutable
	{
		['hour' => $hour, 'minute' => $minute, 'second' => $second, 'modify' => $modify] = self::explodeTime($any);
		if ($modify) {
			$x = $date->modify(self::modifier($hour, $minute, $second));
			assert($x !== false);

			return $x;
		}

		return $date->setTime($hour, $minute, $second);
	}


	/**
	 * @return ($isDateTime is true ? DateTime : DateTimeImmutable)
	 */
	private static function fromFormat(string $any, bool $isDateTime): DateTime|DateTimeImmutable
	{
		$callback = static fn (string $format, string $any) => $isDateTime
			? DateTime::createFromFormat($format, $any)
			: DateTimeImmutable::createFromFormat($format, $any);

		foreach (self::$formats as $format) {
			$date = $callback($format, $any);
			if ($date !== false) {
				return $date;
			}
		}

		throw new InvalidArgumentsException(sprintf('Unknown option format date. "%s"', $any));
	}


	private static function isModification(string $string): bool
	{
		return Arrays::startWith($string, '+', '-');
	}


	/**
	 * @return array{hour: int, minute: int, second: int, modify: bool}
	 */
	private static function explodeTime(string $time): array
	{
		$char = substr($time, 0, 1);
		$way = 1;
		$modify = true;
		if ($char === '-') {
			$way = -1;
			$time = substr($time, 1);
		} elseif ($char === '+') {
			$time = substr($time, 1);
		} else {
			$modify = false;
		}

		[$hour, $minute, $second] = explode(':', $time . ':0:0');

		return [
			'hour' => (int) $hour * $way,
			'minute' => (int) $minute * $way,
			'second' => (int) $second * $way,
			'modify' => $modify,
		];
	}
}




