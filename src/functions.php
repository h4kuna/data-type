<?php declare(strict_types=1);

use h4kuna\DataType\Exceptions;

/**
 * 10% faster than internal static function.
 * @param array{1: string, 2: string, 3: string, 4: string} $find
 * @return string
 */
function underscoreCallback(array $find): string
{
	if (!empty($find[1])) {
		return $find[1] . '_' . $find[2];
	}
	return $find[3] . '_' . $find[4];
}


/**
 * @param array{1: string} $find
 */
function camelCallback(array $find): string
{
	return strtoupper($find[1]);
}

if (!function_exists('_')) {
	/**
	 * @param string $message
	 */
	function _($message): string
	{
		return (string) $message;
	}
}

// back compatibility from 2022-05-31
class_alias(Exceptions\DataTypeException::class, 'h4kuna\DataType\DataTypeException');
class_alias(Exceptions\InvalidArgumentsException::class, 'h4kuna\DataType\InvalidArgumentsException');
class_alias(Exceptions\LogicException::class, 'h4kuna\DataType\LogicException');
