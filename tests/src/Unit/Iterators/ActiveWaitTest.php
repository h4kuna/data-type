<?php declare(strict_types=1);

namespace h4kuna\DataType\Tests\Unit\Iterators;

use h4kuna\DataType\Exceptions\ActiveWaitTimeoutException;
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
					/** @var array<bool> $a */
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


	public function testTimeoutExpired(): void
	{
		$wait = new ActiveWait(0.1, 0.35);
		$calls = 0;

		Debugger::timer();
		$e = Assert::exception(function () use ($wait, &$calls): void {
			$wait->run(static function () use (&$calls): bool {
				++$calls;
				return false;
			});
		}, ActiveWaitTimeoutException::class, 'Active Wait timeout expired after %f% seconds.');
		$elapsed = Debugger::timer();

		Assert::same(4, $calls); // 0.0, 0.1, 0.2, 0.3 -> after 4th sleep 0.4 > 0.35
		Assert::true($elapsed >= 0.35 && $elapsed < 0.6, "elapsed $elapsed");
		Assert::type(\RuntimeException::class, $e);
	}


	public function testTimeoutNotReached(): void
	{
		$wait = new ActiveWait(0.1, 1.0);
		$calls = 0;

		Debugger::timer();
		$wait->run(static function () use (&$calls): bool {
			return ++$calls === 3;
		});

		Assert::same(3, $calls);
		Assert::same(0.2, round(Debugger::timer(), 1));
	}


	public function testWithoutTimeout(): void
	{
		$wait = new ActiveWait(0.1);
		$calls = 0;

		$wait->run(static function () use (&$calls): bool {
			return ++$calls === 6; // 0.5s, longer than any timeout in other tests
		});

		Assert::same(6, $calls);
	}

}

(new ActiveWaitTest())->run();
