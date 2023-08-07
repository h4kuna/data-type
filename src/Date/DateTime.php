<?php declare(strict_types=1);

namespace h4kuna\DataType\Date;

use h4kuna\DataType\Basic\Arrays;
use h4kuna\DataType\Exceptions\InvalidArgumentsException;
use Nette\Utils\Strings;
use Nette\Utils\Validators;

final class DateTime
{
	public static function fromString(string $any, ?\DateTime $dateTime = null): \DateTime
	{
		if ($dateTime === null) {
			$dateTime = new \DateTime();
		}

		$time = ltrim($any, '0');
		if ($time === '') {
			return $dateTime;
		}
		$dateTime = clone $dateTime;
		$prepareFloat = strtr($any, [',' => '.']);

		return match (true) {
			$any === 'now' => new \DateTime(),
			Validators::isNumericInt($any) => self::isModification($any) ? $dateTime->modify(sprintf('%s hour', $any)) : $dateTime->setTime((int) $any, 0),
			Validators::isNumeric($prepareFloat) => $dateTime->modify(self::modifierFromFloat((float) $prepareFloat)),
			self::isTimeFormat($any) => self::fromTimeFormat($any, $dateTime),
			default => self::fromFormat($any),
		};
	}


	private static function modifierFromFloat(float $value): string
	{
		$way = $value < 0 ? -1 : 1;
		[$hour, $minute] = explode('.', (string) $value);

		$minute = intval($minute);
		$hour = intval($hour);
		if ($minute !== 0) {
			$minute = (int) round(6 / (1 / $minute));
		}

		return self::modifier($hour, $minute * $way);
	}


	private static function modifier(int $hour, int $minute, int $second = 0): string
	{
		return sprintf('%s hour, %s minute, %s second', $hour, $minute, $second);
	}


	private static function isTimeFormat(string $any): bool
	{
		return Strings::match($any, '/^[+-]?\d+:\d*(:\d*)?$/') !== null;
	}


	private static function fromTimeFormat(string $any, \DateTime $date): \DateTime
	{
		['hour' => $hour, 'minute' => $minute, 'second' => $second, 'modify' => $modify] = self::explodeTime($any);
		if ($modify) {
			$date->modify(self::modifier($hour, $minute, $second));
		} else {
			$date->setTime($hour, $minute, $second);
		}

		return $date;
	}


	private static function fromFormat(string $any): \DateTime
	{
		$formats = ['d.m. H:i', 'm-d H:i', 'd.m.Y H:i', 'Y-m-d H:i', 'd.m.Y H:i:s', 'Y-m-d H:i:s'];
		foreach ($formats as $format) {
			$date = \DateTime::createFromFormat($format, $any);
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




