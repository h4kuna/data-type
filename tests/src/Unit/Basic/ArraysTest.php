<?php declare(strict_types=1);

namespace h4kuna\DataType\Tests\Unit\Basic;

use h4kuna;
use h4kuna\DataType\Basic\Arrays;
use Tester;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @testCase
 */
final class ArraysTest extends Tester\TestCase
{

	public function testCombine(): void
	{
		Assert::same([1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four'], Arrays::combine([1, 2, 3, 4], [
			'one',
			'two',
			'three',
			'four',
		]));

		Assert::same([1 => 'one', 2 => 'three', 3 => 'four', 4 => null], Arrays::combine([1, 2, 3, 4], [
			'one',
			'three',
			'four',
		]));

		Assert::same([1 => 'one', 2 => 'three', 3 => 'four', 4 => 'five'], Arrays::combine([1, 2, 3, 4], [
			'one',
			'three',
			'four',
		], 'five'));
	}


	/**
	 * @throws h4kuna\DataType\Exceptions\InvalidArgumentsException
	 */
	public function testCombineFail(): void
	{
		Arrays::combine([1, 2, 3, 4], ['one', 'two', 'three', 'four', 'five']);
	}


	public function testConcatWs(): void
	{
		$array = [1 => 0, 2 => null, 3 => 'three', 4 => false, 5 => 'five', 6 => '', 7 => '0'];
		Assert::same('0|three|five|0', Arrays::concatWs('|', $array));
	}


	public function testCoalesce(): void
	{
		Assert::false(Arrays::coalesce([null, false, '', 'foo']));
		Assert::same('foo', Arrays::coalesce(['foo', null, false]));
		Assert::same(null, Arrays::coalesce([]));
	}


	public function testExplode(): void
	{
		Assert::same(['a', 'b'], Arrays::explode('a,b'));
		Assert::same([], Arrays::explode(''));
	}


	public function testKeysUnset(): void
	{
		$array = [1 => 0, 2 => null, 3 => 'three', 4 => false, 5 => 'five', 6 => '', 7 => '0'];
		$newArray = Arrays::unsetKeys($array, 1, 2);
		Assert::same([1 => 0, 2 => null], $newArray);
		Assert::same([3 => 'three', 4 => false, 5 => 'five', 6 => '', 7 => '0'], $array);

		$newArray = Arrays::unsetKeys($array, 'foo');
		Assert::same([], $newArray);
	}


	public function testIntersectKeys(): void
	{
		$array = [1 => 0, 2 => null, 3 => 'three', 4 => false, 5 => 'five', 6 => '', 7 => '0'];
		Assert::same([2 => null, 3 => 'three', 5 => 'five'], Arrays::intersectKeys($array, [2, 3, 5]));
	}


	public function testGenerateNumbers(): void
	{
		Assert::same([10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15], Arrays::generateNumbers(10, 15));
		Assert::same([15 => 15, 14 => 14, 13 => 13, 12 => 12, 11 => 11, 10 => 10,], Arrays::generateNumbers(15, 10));
	}


	public function testMergeUnique(): void
	{
		Assert::same(['a', 'g', 'c', 'd', 'e', 'b', 'f'], Arrays::mergeUnique(['a', 'g', 'c'], ['c', 'd', 'e'], [
			'b',
			'd',
			'f',
		]));
	}


	public function testStartWith(): void
	{
		Assert::true(Arrays::startWith('Lorem', 'Lo'));
		Assert::false(Arrays::startWith('Lorem', 'Ip'));
		Assert::true(Arrays::startWith('Lorem', 'Lo', 'Ip'));
		Assert::true(Arrays::startWith('Ipsum', 'Lo', 'Ip'));
		Assert::false(Arrays::startWith('Unknown', 'L', 'I'));
	}

}

(new ArraysTest())->run();
