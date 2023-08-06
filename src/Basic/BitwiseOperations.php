<?php declare(strict_types=1);

namespace h4kuna\DataType\Basic;

final class BitwiseOperations
{

	public static function check(int $number, int $flag): bool
	{
		return ($number & $flag) !== 0;
	}


	public static function checkStrict(int $number, int $flag): bool
	{
		return ($number & $flag) === $number;
	}


	public static function add(int &$number, int $flag): void
	{
		$number |= $flag;
	}


	public static function remove(int &$number, int $flag): void
	{
		$number &= ~$flag;
	}

}
