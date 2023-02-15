<?php declare(strict_types=1);

namespace h4kuna\DataType\Basic;

use h4kuna\DataType;

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

	/**
	 * @return array<string, true>
	 */
	public static function fromString(string $value): array
	{
		return array_fill_keys(explode(',', $value), true);
	}


	/**
	 * @param iterable<string, mixed> $set
	 */
	public static function toString(iterable $set): string
	{
		$out = [];
		foreach ($set as $k => $v) {
			if ($v !== null && $v !== '' && $v !== false) {
				$out[] = $k;
			}
		}

		return implode(',', $out);
	}

}
