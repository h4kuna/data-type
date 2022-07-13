<?php declare(strict_types=1);

use h4kuna\DataType\Exceptions;

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
