<?php declare(strict_types=1);

namespace h4kuna\DataType\Tests\Unit\Basic;

use h4kuna;
use h4kuna\DataType\Basic\Integer;
use Tester;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @testCase
 */
final class IntegerTest extends Tester\TestCase
{
	/**
	 * @return array<array<mixed>>
	 */
	protected function dataFrom(): array
	{
		return [
			[false, 0],
			[null, 0],
			['', 0],
			[1, 1],
			['1.0', 1],
			['1', 1],
			[' 1 ', 1],
		];
	}


	/**
	 * @dataProvider dataFrom
	 */
	public function testFromString(mixed $input, int $expected): void
	{
		Assert::same($expected, Integer::from($input));
	}


	/**
	 * @throws h4kuna\DataType\Exceptions\InvalidTypeException
	 */
	public function testFailed(): void
	{
		Assert::same(1, Integer::from('1.1')); // not int
	}


	/**
	 * @dataProvider dataFrom
	 */
	public function testNullable(mixed $input, int $expected): void
	{
		if ($input === null) {
			$expected = null;
		}
		Assert::same($expected, Integer::nullable($input));
	}

}

(new IntegerTest())->run();
