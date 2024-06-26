<?php declare(strict_types=1);

namespace h4kuna\DataType\Basic;

use h4kuna\DataType;
use Nette\StaticClass;

/**
 * Transform set from string to array and vice versa
 * MySQL data type SET to checkboxlist
 * @example
 * [
 *  foo => TRUE,
 *  bar => TRUE,
 *  joe => FALSE
 * ]
 * string: foo,bar
 * array: [foo => TRUE, bar => TRUE]
 */
final class Set
{
	use StaticClass;

	/**
	 * @return array<string, true>
	 */
	public static function fromString(string $value): array
	{
		return array_fill_keys(explode(',', $value), true);
	}


	/**
	 * @param array<string, bool|null> $set
	 */
	public static function toString(array $set): string
	{
		$out = [];
		foreach ($set as $k => $v) {
			if ($v !== null && $v !== false) {
				$out[] = $k;
			}
		}

		return implode(',', $out);
	}

}
