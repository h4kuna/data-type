<?php declare(strict_types=1);

namespace h4kuna\DataType\Date;

use DateTimeImmutable;
use h4kuna\Memoize\MemoryStorageStatic;

final class Easter
{
	use MemoryStorageStatic;

	public static ?bool $useNative = null;


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

		return self::memoize([__METHOD__, $year], static fn (
		): DateTimeImmutable => self::$useNative === true ? Convert::timestampToImmutable(self::native($year))->modify('today') : Convert::timestampToImmutable(self::counted($year)));
	}


	/**
	 * Based on https://github.com/steinger/easter-date
	 */
	private static function counted(int $year): int
	{
		$K = floor($year / 100);
		$M = 15 + floor((3 * $K + 3) / 4) - floor((8 * $K + 13) / 25);
		$S = 2 - floor((3 * $K + 3) / 4);
		$A = $year % 19;
		$D = (19 * $A + $M) % 30;
		$R = floor($D / 29) + (floor($D / 28) - floor($D / 29)) * floor($A / 11);
		$OG = 21 + $D - $R; // March date of Easter full moon (= 14. days of the first month in the moon calendar, called Nisanu)
		$SZ = 7 - (($year + floor($year / 4) + $S) % 7); // Date first Sunday of March
		$OE = 7 - (($OG - $SZ) % 7);
		$OS = $OG + $OE;

		$result = mktime(0, 0, 0, 3, (int) $OS, $year);
		assert($result !== false);

		return $result;
	}


	private static function native(int $year): int
	{
		return easter_date($year);
	}


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
	public static function friday(?int $year = null): DateTimeImmutable
	{
		return self::sunday($year)->modify('-2 days');
	}
}
