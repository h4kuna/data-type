<?php declare(strict_types=1);

namespace h4kuna\DataType\Date;

final class Sleep
{
	/**
	 * @param float $duration like 0.5 as half second
	 */
	public static function seconds(float $duration): void
	{
		self::usleep((int) ($duration * 1_000_000.0));
	}


	/**
	 * @param int $duration like 500 as half second
	 */
	public static function milliseconds(int $duration): void
	{
		self::usleep($duration * 1_000);
	}


	private static function usleep(int $microseconds): void
	{
		if ($microseconds > 0) {
			usleep($microseconds);
		}
	}
}
