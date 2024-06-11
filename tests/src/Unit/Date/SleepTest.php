<?php declare(strict_types=1);

namespace h4kuna\DataType\Tests\Unit\Date;

use h4kuna\DataType\Date\Sleep;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @testCase
 */
final class SleepTest extends TestCase
{
	/**
	 * @return array<mixed>
	 */
	public static function dataSeconds(): array
	{
		return [
			[
				0.5,
			],
			[
				1.1,
			],
		];
	}


	/**
	 * @dataProvider dataSeconds
	 */
	public function testSeconds(float $sleep): void
	{
		$start = microtime(true);
		Sleep::seconds($sleep);
		Assert::same($sleep, round(microtime(true) - $start, 1));
	}


	/**
	 * @param int<0, max> $sleep
	 * @dataProvider provideMilliseconds
	 */
	public function testMilliseconds(int $sleep): void
	{
		$start = microtime(true);
		Sleep::milliseconds($sleep);
		Assert::same($sleep / 1_000, round(microtime(true) - $start, 1));
	}


	/**
	 * @return array<mixed>
	 */
	protected function provideMilliseconds(): array
	{
		return [
			[500],
			[1100],
		];
	}
}

(new SleepTest())->run();
