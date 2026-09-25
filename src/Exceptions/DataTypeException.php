<?php declare(strict_types=1);

namespace h4kuna\DataType\Exceptions;

use RuntimeException;
use Throwable;

abstract class DataTypeException extends RuntimeException
{
	protected function __construct(string $message = '', ?Throwable $previous = null)
	{
		parent::__construct($message, $previous === null ? 0 : $previous->getCode(), $previous);
	}
}
