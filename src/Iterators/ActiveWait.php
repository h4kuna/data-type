<?php declare(strict_types=1);

namespace h4kuna\DataType\Iterators;

use h4kuna\DataType\Date\Sleep;
use h4kuna\DataType\Date\Time;
use h4kuna\DataType\Exceptions\ActiveWaitTimeoutException;

final readonly class ActiveWait
{

	public function __construct(
		private float $sleep = 0.1,
		private float $timeoutSeconds = 0.0,
	) {
	}

	/**
	 * @param callable(): bool $callback
	 *
	 * @throws ActiveWaitTimeoutException
	 */
	public function run(callable $callback): void
	{
		$start = $this->timeoutSeconds > 0 ? Time::micro() : null;

		run:
		$return = ($callback)();
		if ($return === false) {
			Sleep::seconds($this->sleep);
			if ($start !== null) {
				$duration = Time::micro() - $start;
				if ($duration > $this->timeoutSeconds) {
					throw ActiveWaitTimeoutException::createAfterTimeout($duration);
				}
			}
			goto run;
		}
	}

}
