<?php

namespace h4kuna\DataType\Location;

use h4kuna\DataType;

final class Gps
{

	private function __construct() { }

	/**
	 * @param string $value
	 * @return float[]
	 * @throws DataType\InvalidArgumentsException
	 */
	public static function fromString($value)
	{
		$out = $found = [];
		if (preg_match('~^(\d{1,3}\.\d+?)(N|S), ?(\d{1,3}\.\d+?)(E|W)$~i', $value, $found)) {
			// 50.4113628N, 14.9032000E
			$out = self::setCoordinate(self::checkCoordinate($found[1], $found[2]), self::checkCoordinate($found[3], $found[4]));
		} elseif (preg_match('~(-?\d{1,3}\.\d+), ?(-?\d{1,3}\.\d+)$~', $value, $found)) {
			// 50.4113628, 14.9032000
			$out = self::setCoordinate($found[1], $found[2]);
		} elseif (preg_match('~^(N|S) ?(\d{1,3})°(\d{1,2}\.\d+?)\',? ?(W|E) ?(\d{1,3})°(\d{1,2}\.\d+?)\'$~i', $value, $found)) {
			// N 50°24.68177', E 14°54.19200'
			$out = self::setCoordinate(self::checkCoordinate(self::degToDec($found[2], $found[3]), $found[1]), self::checkCoordinate(self::degToDec($found[5], $found[6]), $found[4]));
		} elseif (preg_match('~^(\d{1,3})°(\d{1,2})\'(\d{1,2}\.\d+?)"(N|S), ?(\d{1,3})°(\d{1,2})\'(\d{1,2}\.\d+?)"(W|E)$~i', $value, $found)) {
			// 50°24'40.906"N, 14°54'11.520"E
			$out = self::setCoordinate(self::checkCoordinate(self::degToDec($found[1], $found[2], $found[3]), $found[4]), self::checkCoordinate(self::degToDec($found[5], $found[6], $found[7]), $found[8]));
		} elseif (preg_match('~^(N|S)(\d{1,3}\.\d+?)° ?(E|W)(\d{1,3}\.\d+?)°$~i', $value, $found)) {
			// N49.20811° E19.04247°
			$out = self::setCoordinate(self::checkCoordinate($found[2], $found[1]), self::checkCoordinate($found[4], $found[3]));
		} else {
			throw new DataType\InvalidArgumentsException('Unsupported coordinate. ' . $value);
		}
		return $out;
	}

	/**
	 * Transform coordinate.
	 * @param float $num
	 * @param string $pole
	 * @return float
	 * @throws DataType\InvalidArgumentsException
	 */
	private static function checkCoordinate($num, $pole)
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
				throw new DataType\InvalidArgumentsException('Unsupported pole ' . $pole);
		}

		if ($num > 180) {
			throw new DataType\InvalidArgumentsException('Coordinate can be higher then 180 ' . $num);
		}

		return $num;
	}

	/**
	 * Transform to float.
	 * @param float $degrees
	 * @param float $minutes
	 * @param float $seconds
	 * @return float
	 */
	private static function degToDec($degrees, $minutes, $seconds = 0.0)
	{
		return $degrees + $minutes / 60 + $seconds / 3600;
	}

	/**
	 * @param float $x
	 * @param float $y
	 * @return float[]
	 */
	private static function setCoordinate($x, $y)
	{
		return [$x, $y];
	}

}
