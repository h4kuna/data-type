<?php declare(strict_types=1);

namespace h4kuna\DataType\Iterators;

use h4kuna\DataType\Date\Sleep;

final class ActiveWait
{

	public function __construct(
		private float $sleep = 0.1,
	)
	{
	}


	public function run(callable $callback): void
	{
		run:
		$return = ($callback)();
		if ($return === false) {
			Sleep::seconds($this->sleep);
			goto run;
		}
	}

}
