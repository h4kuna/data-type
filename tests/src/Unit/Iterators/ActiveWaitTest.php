<?php declare(strict_types=1);

namespace h4kuna\DataType\Tests\Unit\Iterators;

use h4kuna\DataType\Iterators\ActiveWait;
use Tester\Assert;
use Tester\TestCase;
use Tracy\Debugger;

require __DIR__ . '/bootstrap.php';

/**
 * @testCase
 */
final class ActiveWaitTest extends TestCase
{
	/**
	 * @return array<mixed>
	 */
	protected function provideWait(): array
	{
		return [
			[0, fn () => true],
			[
				0.4,
				static function () {
					static $a = [false, false, true];
					return array_shift($a);
				},
			],
		];
	}


	/**
	 * @dataProvider provideWait
	 */
	public function testWait(float $expected, \Closure $callback): void
	{
		$wait = new ActiveWait(0.2);
		Debugger::timer();
		$wait->run($callback);
		Assert::same($expected, round(Debugger::timer(), 2));
	}

}

(new ActiveWaitTest())->run();
