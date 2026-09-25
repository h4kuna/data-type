<?php declare(strict_types = 1);

namespace h4kuna\DataType\Basic;

use h4kuna\DataType\Exceptions\InvalidTypeException;
use Nette\StaticClass;
use Nette\Utils\Strings as NetteStrings;
use function assert;
use function explode;
use function is_array;
use function is_bool;
use function is_numeric;
use function is_object;
use function is_string;
use function pow;
use function str_replace;
use function str_starts_with;
use function substr;

final class Floats
{

	use StaticClass;

	/**
	 * @throws InvalidTypeException
	 */
	public static function nullable(mixed $value): ?float
	{
		return $value === null ? null : self::from($value);
	}

	/**
	 * @throws InvalidTypeException
	 */
	public static function from(
		mixed $value,
		string $decimalPoint = ',',
		string $thousandSeparator = ' ',
	): float
	{
		if (is_numeric($value) || $value === '' || is_bool($value) || $value === null) {
			return (float) $value;
		} elseif (is_array($value) || is_object($value)) {
			throw InvalidTypeException::createInvalidFloat($value);
		}
		assert(is_string($value));

		if (NetteStrings::match($value, '/^\d{1,2}:\d{1,2}(:\d{1,2})?$/') !== null) {
			return self::fromHour($value);
		}

		$out = str_replace([$thousandSeparator, $decimalPoint], ['', '.'], $value);
		if (is_numeric($out)) {
			return (float) $out;
		}

		throw InvalidTypeException::createInvalidFloat($value);
	}

	/**
	 * Format HH:MM or HH:MM:SS
	 *
	 * @throws InvalidTypeException
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
