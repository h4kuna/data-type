<?php declare(strict_types=1);

namespace h4kuna\DataType\Tests\Unit\Date;

use h4kuna\DataType\Date\Time;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @testCase
 */
final class TimeTest extends TestCase
{

	/**
	 * @dataProvider provideOnly
	 */
	public function testOnly(int $expected, string $time): void
	{
		Assert::same($expected, Time::only(new \DateTime($time)));
	}


	/**
	 * @dataProvider provideOnly
	 */
	public function testOnlyString(int $expected, string $time): void
	{
		Assert::same($expected, Time::only($time));
	}


	/**
	 * @return array<mixed>
	 */
	protected function provideOnly(): array
	{
		return [
			[0, 'today'],
			[70215, '19:30:15'],
			[25141, '6:59:01'],
			[25140, '6:59'],
		];
	}

}

(new TimeTest())->run();
