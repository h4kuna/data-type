<?php declare(strict_types=1);

namespace h4kuna\DataType\Basic;

use h4kuna\DataType;
use h4kuna\DataType\Exceptions\InvalidTypeException;
use Nette\Utils;

final class Floats
{

	public static function from(
		mixed $value,
		string $decimalPoint = ',',
		string $thousandSeparator = ' '
	): float
	{
		if (is_numeric($value) || $value === '' || is_bool($value) || $value === null) {
			return (float) $value;
		} elseif (is_array($value) || is_object($value)) {
			throw InvalidTypeException::invalidFloat($value);
		}
		assert(is_string($value));

		if (Utils\Strings::match($value, '/^\d{1,2}:\d{1,2}(:\d{1,2})?$/') !== null) {
			return self::fromHour($value);
		}

		$out = str_replace([$thousandSeparator, $decimalPoint], ['', '.'], $value);
		if (is_numeric($out)) {
			return (float) $out;
		}

		throw InvalidTypeException::invalidFloat($value);
	}


	/**
	 * Format HH:MM or HH:MM:SS
	 */
	public static function fromHour(string $value): float
	{
		$minus = false;
		if (str_starts_with($value, '-')) {
			$minus = true;
			$value = substr($value, 1);
		}
		$out = 0.0;
		foreach (explode(':', $value) as $i => $v) {
			$out += (Integer::from($v) / pow(60, $i));
		}

		return $minus ? $out * -1 : $out;
	}

}
