<?php declare(strict_types=1);

namespace h4kuna\DataType\Tests\Unit\Basic;

use h4kuna;
use h4kuna\DataType\Basic\Floats;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @testCase
 */
final class FloatsTest extends \Tester\TestCase
{
	/**
	 * @return array<array<mixed>>
	 */
	protected function dataFrom(): array
	{
		return [
			['0', 0.0],
			['0.0', 0.0],
			['-0.0', 0.0],
			['-.0', 0.0],
			['-0.', 0.0],
			['', 0.0],
			[null, 0.0],
			[false, 0.0],
			[true, 1.0],
			[-1, -1.0],
			[-1.0, -1.0],
			['-1', -1.0],
			['-1.0', -1.0],
			['-1,0', -1.0],
			[' - 1 , 0 ', -1.0],
			['1:30', 1.5],
		];
	}


	/**
	 * @dataProvider dataFrom
	 */
	public function testFromString(mixed $input, float $expected): void
	{
		Assert::same($expected, Floats::from($input));
	}


	/**
	 * @throws h4kuna\DataType\Exceptions\InvalidTypeException
	 */
	public function testExceptionFloatChar(): void
	{
		Assert::same(-1.0, Floats::from('-1,d0'));
	}


	public function testFromHour(): void
	{
		Assert::same(0.0, Floats::fromHour('0:0:0'));
		Assert::same(1.5, Floats::fromHour('1:30'));
		Assert::same(1.5, Floats::fromHour('1:30:0'));
		Assert::same(1.5083, round(Floats::fromHour('1:30:30'), 4));
		Assert::same(-3.5, Floats::fromHour('-3:30'));
	}


	public function testThousand(): void
	{
		Assert::same(3620.0, Floats::from('3.620,00', ',', '.'));
	}


	/**
	 * @dataProvider dataFrom
	 */
	public function testNullable(mixed $input, float $expected): void
	{
		if ($input === null) {
			$expected = null;
		}
		Assert::same($expected, Floats::nullable($input));
	}

}

(new FloatsTest())->run();
