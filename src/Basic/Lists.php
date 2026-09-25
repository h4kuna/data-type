<?php declare(strict_types=1);

namespace h4kuna\DataType\Basic;

/**
 * These methods of class return list only
 */
final class Lists
{
	/**
	 * @param array<mixed> $array
	 * @return list<string>
	 */
	public static function stringKeys(array $array): array
	{
		$out = [];
		foreach ($array as $key => $value) {
			$out[] = strval($key);
		}

		return $out;
	}
}
