<?php declare(strict_types=1);

namespace h4kuna\DataType\Date;

use Nette\StaticClass;

final class Sleep
{
	use StaticClass;

	/**
	 * @param float $duration like 0.5 as half second
	 */
	public static function seconds(float $duration): void
	{
		$seconds = (int) $duration;
		if ($seconds > 0) {
			sleep($seconds);
		}

		$milli = $duration - $seconds;
		if ($milli > 0) {
			self::sleep($milli * 1_000.0);
		}
	}


	/**
	 * @param int<0, max> $duration like 500 as half second
	 */
	public static function milliseconds(int $duration): void
	{
		if ($duration > 0) {
			if ($duration > 999) {
				self::seconds($duration / 1_000.0);
			} else {
				self::sleep($duration);
			}
		}
	}


	private static function sleep(int|float $milli): void
	{
		usleep((int) ($milli * 1_000.0));
	}
}
