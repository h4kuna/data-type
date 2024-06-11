<?php declare(strict_types=1);

namespace h4kuna\DataType\Number;

use Nette\StaticClass;

/**
 * @example
 * echo RomeNumber::getRome(1968); // MCMLXVIII
 * echo RomeNumber::getArabic('MCMLXVIII'); // 1968
 * @see https://php.vrana.cz/rimske-cislice.php
 */
class RomeNumber
{
	use StaticClass;

	private const NUMBERS = [
		'M' => 1000,
		'CM' => 900,
		'D' => 500,
		'CD' => 400,
		'C' => 100,
		'XC' => 90,
		'L' => 50,
		'XL' => 40,
		'X' => 10,
		'IX' => 9,
		'V' => 5,
		'IV' => 4,
		'I' => 1,
	];


	/**
	 * Transform from arabic to rome
	 */
	public static function getRome(int $number): string
	{
		$return = null;
		foreach (self::NUMBERS as $key => $val) {
			$return .= str_repeat($key, (int) floor($number / $val));
			$number %= $val;
		}

		return $return;
	}


	/**
	 * Transform form rome to arabic
	 */
	public static function getArabic(string $rome): int
	{
		$return = 0;
		$move = false;
		$rome = str_split(strtoupper($rome));
		foreach ($rome as $key => $val) {
			if ($move === true) {
				$move = false;
				continue;
			}

			if (isset($rome[$key + 1]) && isset(self::NUMBERS[$val . $rome[$key + 1]])) {
				$return += self::NUMBERS[$val . $rome[$key + 1]];
				$move = true;
			} else {
				$return += self::NUMBERS[$val];
			}
		}

		return $return;
	}

}
