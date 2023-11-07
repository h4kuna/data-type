<?php declare(strict_types=1);

namespace h4kuna\DataType\Tests\Unit\Iterators;

use h4kuna\DataType\Iterators\ReverseArray;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/bootstrap.php';

/**
 * @testCase
 */
final class ReverseArrayTest extends TestCase
{
	/**
	 * @return array<mixed>
	 */
	protected function basicProvider(): array
	{
		return [
			[
				[1, 2, 3],
				[2 => 3, 1 => 2, 0 => 1],
			],
			[
				[],
				[],
			],
		];
	}


	/**
	 * @dataProvider basicProvider
	 * @param array<mixed> $source
	 * @param array<mixed> $expected
	 */
	public function testBasic(array $source, array $expected): void
	{
		$actual = [];
		foreach (new ReverseArray($source) as $k => $v) {
			$actual[$k] = $v;
		}
		Assert::same($expected, $actual);
	}
}

(new ReverseArrayTest())->run();
