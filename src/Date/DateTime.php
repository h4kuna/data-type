<?php declare(strict_types=1);

namespace h4kuna\DataType\Date;

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

		$time = trim($any, '0');
		if ($time === '') {
			return $dateTime;
		}
		$dateTime = clone $dateTime;
		$prepareFloat = strtr($any, [',' => '.']);

		return match (true) {
			$any === 'now' => new \DateTime(),
			Validators::isNumericInt($any) => $dateTime->modify(sprintf('+%s hour', $any)),
			Validators::isNumeric($prepareFloat) => $dateTime->modify(self::modifierFromFloat((float) $prepareFloat)),
			self::isTimeFormat($any) => self::fromTimeFormat($any, $dateTime),
			default => self::fromFormat($any),
		};
	}


	private static function modifierFromFloat(float $value): string
	{
		[$hour, $minute] = explode('.', (string) $value);

		$minute = intval($minute);
		$hour = intval($hour);
		if ($minute !== 0) {
			$minute = (int) round(6 / (1 / $minute));
		}

		return self::modifier($hour, $minute);
	}


	private static function modifier(string|int $hour, string|int $minute): string
	{
		$hour = (string) $hour;
		$minute = (string) $minute;

		if (trim($hour) === '') {
			$hour = '0';
		}
		if (trim($minute) === '') {
			$minute = '0';
		}

		return sprintf('+%s hour, +%s minute', $hour, $minute);
	}


	private static function isTimeFormat(string $any): bool
	{
		return Strings::match($any, '/^\d+:\d*(:\d*)?$/') !== null;
	}


	private static function fromTimeFormat(string $any, \DateTime $date): \DateTime
	{
		[$hour, $minute, $second] = explode(':', $any . ':0:0');
		$date->setTime((int) $hour, (int) $minute, (int) $second);

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
}




