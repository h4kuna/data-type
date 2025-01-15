<?php declare(strict_types=1);

namespace h4kuna\DataType\Tests\Unit\Iterators;

use h4kuna\DataType\Iterators\ReverseIterator;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/bootstrap.php';

/**
 * @testCase
 */
final class ReverseIteratorTest extends TestCase
{
	/**
	 * @return array<mixed>
	 */
	protected function basicProvider(): array
	{
		return [
			[
				['a' => 1, 'b' => 2, 'c' => 3],
				['c' => 3, 'b' => 2, 'a' => 1],
			],
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
		$x = new \h4kuna\DataType\Iterators\ReverseIterator([]); // deprecated
		Assert::type(ReverseIterator::class, $x);

		$actual = [];
		foreach (new ReverseIterator($source) as $k => $v) {
			$actual[$k] = $v;
		}
		Assert::same($expected, $actual);
	}
}

(new ReverseIteratorTest())->run();
