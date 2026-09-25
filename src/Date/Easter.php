<?php declare(strict_types = 1);

namespace h4kuna\DataType\Date;

use DateTimeImmutable;
use Nette\StaticClass;
use function assert;
use function date;
use function easter_date;
use function floor;
use function function_exists;
use function mktime;

final class Easter
{

	use StaticClass;

	public static ?bool $useNative = null;


	/**
	 * @param ?int<1970, 2037> $year
	 */
	public static function monday(?int $year = null): DateTimeImmutable
	{
		return self::sunday($year)->modify('+1 day');
	}

	/**
	 * @param ?int<1970, 2037> $year
	 */
	public static function sunday(?int $year = null): DateTimeImmutable
	{
		if (self::$useNative === null) {
			self::$useNative = function_exists('easter_date');
		}

		if ($year === null) {
			$year = (int) date('Y');
		}

		return self::$useNative
			? Convert::timestampToImmutable(self::native($year))->modify('today')
			: Convert::timestampToImmutable(self::counted($year));
	}

	private static function native(int $year): int
	{
		return easter_date($year);
	}

	/**
	 * Based on https://github.com/steinger/easter-date
	 */
	private static function counted(int $year): int
	{
		$k = floor($year / 100);
		$m = 15 + floor((3 * $k + 3) / 4) - floor((8 * $k + 13) / 25);
		$s = 2 - floor((3 * $k + 3) / 4);
		$a = $year % 19;
		$d = (19 * $a + $m) % 30;
		$r = floor($d / 29) + (floor($d / 28) - floor($d / 29)) * floor($a / 11);
		$og = 21 + $d - $r; // March date of Easter full moon (= 14. days of the first month in the moon calendar, called Nisanu)
		$sz = 7 - (($year + floor($year / 4) + $s) % 7); // Date first Sunday of March
		$oe = 7 - (($og - $sz) % 7);
		$os = $og + $oe;

		$result = mktime(0, 0, 0, 3, (int) $os, $year);
		assert($result !== false);

		return $result;
	}

	/**
	 * @param ?int<1970, 2037> $year
	 */
	public static function friday(?int $year = null): DateTimeImmutable
	{
		return self::sunday($year)->modify('-2 days');
	}

}
