<?php declare(strict_types=1);

namespace h4kuna\DataType\Exceptions;

final class ActiveWaitTimeoutException extends \RuntimeException
{

	public static function createAfterTimeout(float $timeoutSeconds): self
	{
		return new self("Active Wait timeout expired after {$timeoutSeconds} seconds.");
	}
}
