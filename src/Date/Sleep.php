<?php declare(strict_types = 1);

namespace h4kuna\DataType\Date;

use Nette\StaticClass;
use function sleep;
use function usleep;

final class Sleep
{

	use StaticClass;

	/**
	 * @param int|float $duration like 500.52 as half second
	 */
	public static function milliseconds(int|float $duration): void
	{
		if ($duration <= 0) {
			return;
		}

		if ($duration >= 1000) {
			self::seconds($duration / 1_000.0);
		} else {
			self::microSleep($duration);
		}
	}

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
			self::microSleep($milli * 1_000.0);
		}
	}

	private static function microSleep(int|float $milli): void
	{
		usleep((int) ($milli * 1_000.0));
	}

}
