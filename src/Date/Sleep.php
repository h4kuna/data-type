<?php declare(strict_types=1);

namespace h4kuna\DataType\Date;

use h4kuna\DataType\Exceptions\InvalidArgumentsException;

final class Sleep
{
	/**
	 * @param float $duration like 0.5 as half second
	 */
	public static function seconds(float $duration): void
	{
		usleep((int) ($duration * 1_000_000.0));
	}


	/**
	 * @param int $duration like 500 as half second
	 */
	public static function milliseconds(int $duration): void
	{
		self::seconds($duration / 1_000.0);
	}

}
