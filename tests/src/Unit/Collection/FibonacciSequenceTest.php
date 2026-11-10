<?php declare(strict_types = 1);

namespace h4kuna\DataType\Tests\Unit\Collection;

use h4kuna\DataType\Collection\FibonacciSequence;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @testCase
 */
final class FibonacciSequenceTest extends TestCase
{

	/**
	 * @param list<int> $expected
	 * @param positive-int $count
	 * @param positive-int $min
	 *
	 * @dataProvider provideCalculate
	 */
	public function testCalculate(
		array $expected,
		int $count,
		int $min,
	): void
	{
		Assert::same($expected, FibonacciSequence::calculate(count: $count, min: $min));
	}

	/**
	 * @return array<string, array{list<int>, int, int}>
	 */
	public static function provideCalculate(): array
	{
		return [
			'start of the sequence' => [[1, 2, 3, 5, 8, 13, 21, 34, 55, 89], 10, 1],
			'min is fibonacci number' => [[5, 8, 13, 21, 34], 5, 5],
			'min is not fibonacci number, 3 is before' => [[4, 7, 11, 18], 4, 4],
			'min is fibonacci number, 3 is before' => [[5, 8, 13, 21], 4, 5],
			'min is between 5 and 8' => [[6, 11, 17], 3, 6],
			'min is 1 and 1' => [[1], 1, 1],
			'min is 2' => [[2, 3, 5], 3, 2],
			'min is 3' => [[3, 5, 8], 3, 3],
			'one item is min' => [[100], 1, 100],
			'big min' => [[1_346_270, 2_692_539, 4_038_809], 3, 1_346_270],
		];
	}

	public function testDefault(): void
	{
		Assert::same([1, 2, 3, 5, 8, 13, 21, 34, 55, 89], FibonacciSequence::calculate());
	}

	public function testPosition(): void
	{
		// min 5, the sixth value after it
		Assert::same(89, FibonacciSequence::calculate(count: 7, min: 5)[6]);
	}

	public function testLargestInt(): void
	{
		$numbers = FibonacciSequence::calculate(count: 91);

		Assert::count(91, $numbers);
		Assert::same(7_540_113_804_746_346_429, $numbers[90]);
	}

}

(new FibonacciSequenceTest())->run();
