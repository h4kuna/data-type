<?php declare(strict_types=1);

namespace h4kuna\DataType\Tests\Unit\Iterators;

use h4kuna\DataType\Iterators\FlattenArrayRecursiveIterator;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

/**
 * @testCase
 */
final class FlattenArrayRecursiveIteratorTest extends TestCase
{

	/**
	 * @param array<string, scalar> $expected
	 * @param array<string, mixed> $input
	 * @dataProvider sourceData
	 */
	public function testBasic(array $expected, array $input, string $delimiter): void
	{
		$iterator = new FlattenArrayRecursiveIterator($input, $delimiter);
		$output = [];
		foreach ($iterator as $key => $item) {
			$output[$key] = $item;
		}

		Assert::same($expected, $output);
	}


	/**
	 * @return array<array<mixed>>
	 */
	public static function sourceData(): array
	{
		$input = [
			'address' => [
				'street' => 'foo',
				'zip' => 29404,
				'c' => [
					'p' => '5',
					'e' => 10.6,
				],
			],
			'main' => ['a', 'b', 'c'],
			'email' => 'exampl@foo.com',
		];

		return [
			[
				'expected' => [],
				'input' => [],
				'delimiter' => '-',
			],

			[
				'expected' => [
					'address%street' => 'foo',
					'address%zip' => 29404,
					'address%c%p' => '5',
					'address%c%e' => 10.6,
					'main%0' => 'a',
					'main%1' => 'b',
					'main%2' => 'c',
					'email' => 'exampl@foo.com',
				],
				'input' => $input,
				'delimiter' => '%',
			],

			[
				'expected' => [
					'address-street' => 'foo',
					'address-zip' => 29404,
					'address-c-p' => '5',
					'address-c-e' => 10.6,
					'main-0' => 'a',
					'main-1' => 'b',
					'main-2' => 'c',
					'email' => 'exampl@foo.com',
				],
				'input' => $input,
				'delimiter' => '-',
			],

			[
				'expected' => [
					'' => 'bar',
				],
				'input' => [
					'' => 'bar',
				],
				'delimiter' => '-',
			],
		];
	}

}

(new FlattenArrayRecursiveIteratorTest())->run();
