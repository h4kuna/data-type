<?php declare(strict_types=1);

namespace h4kuna\DataType\Tests\Unit\Basic;

use h4kuna;
use h4kuna\DataType\Basic\Bools;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @testCase
 */
final class BoolsTest extends TestCase
{

	/**
	 * @return array<array<mixed>>
	 */
	protected function dataFrom(): array
	{
		return [
			[true, true],
			[false, false],
			[null, false],
			[1, true],
			[0, false],
			[1.0, true],
			[0.0, false],
			['1', true],
			['0', false],
			['', false],
		];
	}


	/**
	 * @dataProvider dataFrom
	 */
	public function testFrom(mixed $input, bool $expected): void
	{
		Assert::same($expected, Bools::from($input));
	}


	/**
	 * @return array<array<mixed>>
	 */
	protected static function dataFromFailed(): array
	{
		return [
			['foo'],
			[2],
			[2.0],
		];
	}


	/**
	 * @dataProvider dataFromFailed
	 * @throws h4kuna\DataType\Exceptions\InvalidTypeException
	 */
	public function testFromFailed(mixed $input): void
	{
		Bools::from($input);
	}


	/**
	 * @dataProvider dataFrom
	 */
	public function testNullable(mixed $input, bool $expected): void
	{
		if ($input === null) {
			$expected = null;
		}
		Assert::same($expected, Bools::nullable($input));
	}

}

(new BoolsTest())->run();
