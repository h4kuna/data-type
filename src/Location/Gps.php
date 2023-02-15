<?php declare(strict_types=1);

namespace h4kuna\DataType\Location;

use h4kuna\DataType;
use h4kuna\DataType\Exceptions\InvalidArgumentsException;
use Nette\Utils\Strings;

final class Gps
{

	private function __construct()
	{
	}


	/**
	 * @return array{lat: float, long: float}
	 */
	public static function fromString(string $value): array
	{
		if (($found = Strings::match($value, '~^(\d{1,3}\.\d+?)(N|S), ?(\d{1,3}\.\d+?)(E|W)$~i')) !== null) {
			assert(isset($found[1], $found[2], $found[3], $found[4]));

			// 50.4113628N, 14.9032000E
			return self::coordinate(self::checkCoordinate((float) $found[1], $found[2]), self::checkCoordinate((float) $found[3], $found[4]));
		} elseif (($found = Strings::match($value, '~(-?\d{1,3}\.\d+), ?(-?\d{1,3}\.\d+)$~')) !== null) {
			assert(isset($found[1], $found[2]));

			// 50.4113628, 14.9032000
			return self::coordinate((float) $found[1], (float) $found[2]);
		} elseif (($found = Strings::match($value, '~^(N|S) ?(\d{1,3})°(\d{1,2}\.\d+?)\',? ?(W|E) ?(\d{1,3})°(\d{1,2}\.\d+?)\'$~i')) !== null) {
			assert(isset($found[1], $found[2], $found[3], $found[4], $found[5], $found[6]));

			// N 50°24.68177', E 14°54.19200'
			return self::coordinate(self::checkCoordinate(self::degToDec((float) $found[2], (float) $found[3]), $found[1]), self::checkCoordinate(self::degToDec((float) $found[5], (float) $found[6]), $found[4]));
		} elseif (($found = Strings::match($value, '~^(\d{1,3})°(\d{1,2})\'(\d{1,2}\.\d+?)"(N|S), ?(\d{1,3})°(\d{1,2})\'(\d{1,2}\.\d+?)"(W|E)$~i')) !== null) {
			assert(isset($found[1], $found[2], $found[3], $found[4], $found[5], $found[6], $found[7], $found[8]));

			// 50°24'40.906"N, 14°54'11.520"E
			return self::coordinate(self::checkCoordinate(self::degToDec((float) $found[1], (float) $found[2], (float) $found[3]), $found[4]), self::checkCoordinate(self::degToDec((float) $found[5], (float) $found[6], (float) $found[7]), $found[8]));
		} elseif (($found = Strings::match($value, '~^(N|S)(\d{1,3}\.\d+?)° ?(E|W)(\d{1,3}\.\d+?)°$~i')) !== null) {
			assert(isset($found[1], $found[2], $found[3], $found[4]));

			// N49.20811° E19.04247°
			return self::coordinate(self::checkCoordinate((float) $found[2], $found[1]), self::checkCoordinate((float) $found[4], $found[3]));
		} else {
			throw new InvalidArgumentsException('Unsupported coordinate. ' . $value);
		}
	}


	/**
	 * Transform coordinate.
	 */
	private static function checkCoordinate(float $num, string $pole): float
	{
		switch (strtoupper($pole)) {
			case 'W':
			case 'S':
				if ($num > 0) {
					$num *= -1;
				}
				break;
			case 'E':
			case 'N':
				if ($num < 0) {
					$num *= -1;
				}
				break;
			default :
				throw new InvalidArgumentsException('Unsupported pole ' . $pole);
		}

		if ($num > 180) {
			throw new InvalidArgumentsException('Coordinate can be higher then 180 ' . $num);
		}

		return $num;
	}


	private static function degToDec(int|float $degrees, int|float $minutes, int|float $seconds = 0.0): float
	{
		return (float) ($degrees + $minutes / 60 + $seconds / 3600);
	}


	/**
	 * @return array{lat: float, long: float}
	 */
	private static function coordinate(float $x, float $y): array
	{
		return [$x, $y, 'lat' => $x, 'long' => $y];
	}

}
