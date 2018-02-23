<?php

namespace h4kuna\DataType\Basic;

use Iterator,
	h4kuna\DataType;

/**
 * Transform set from string to array and vice versa
 * MySQL data type SET to checkboxlist
 * @example
 * array(
 *  foo => TRUE,
 *  bar => TRUE,
 *  joe => FALSE
 * )
 * string: foo,bar
 * array: [foo => TRUE, bar => TRUE]
 * @author Milan Matějček
 */
final class Set
{

	private function __construct() { }

	/**
	 * @param string $value
	 * @return array
	 * @throws DataType\InvalidArgumentsException
	 */
	public static function fromString($value)
	{
		if (!is_string($value)) {
			throw new DataType\InvalidArgumentsException('Set must be string and delimited by comma. For example: foo,bar,joe');
		}
		return array_fill_keys(explode(',', $value), true);
	}

	/**
	 * @param array|Iterator $set
	 * @return string
	 */
	public static function toString($set)
	{
		$out = '';
		foreach ($set as $k => $v) {
			if ($v) {
				if ($out !== '') {
					$out .= ',';
				}
				$out .= $k;
			}
		}
		return $out;
	}

}
