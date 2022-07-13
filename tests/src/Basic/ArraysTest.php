<?php

namespace h4kuna\DataType\Basic;

use Tester\Assert;

include __DIR__ . '/../../bootstrap.php';

final class ArraysTest extends \Tester\TestCase
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
	 * @throws \h4kuna\DataType\Exceptions\InvalidArgumentsException
	 */
	public function testCombineFail(): void
	{
		Arrays::combine([1, 2, 3, 4], ['one', 'two', 'three', 'four', 'five']);
	}


	public function testConcatWs(): void
	{
		$array = [1 => 0, 2 => null, 3 => 'three', 4 => false, 5 => 'five', 6 => '', 7 => '0'];
		Assert::same('0|three|five|0', Arrays::concatWs('|', $array));
		Assert::same('five', Arrays::concatWs('|', $array, 2, 4, 5, 6));
		Assert::same('three|five', Arrays::concatWs('|', $array, 2, 3, 4, 5, 6));
		Assert::same('five', Arrays::concatWs('|', $array, 2, 5, 5, 6));
	}


	public function testCoalesce(): void
	{
		Assert::same('foo', Arrays::coalesce([null, false, '', 'foo']));
		Assert::same('foo', Arrays::coalesce([null, false, 'foo']));
		Assert::same('foo', Arrays::coalesce(['foo', null, false]));
		Assert::same('foo', Arrays::coalesce(['bar', null, 'foo'], 1, 2));

		Assert::same(null, Arrays::coalesce([false, null, '']));
		Assert::same(null, Arrays::coalesce([]));
		Assert::same(null, Arrays::coalesce([], 1));
	}


	public function testKeysUnset(): void
	{
		$array = [1 => 0, 2 => null, 3 => 'three', 4 => false, 5 => 'five', 6 => '', 7 => '0'];
		$newArray = Arrays::keysUnset($array, 1, 2);
		Assert::same([1 => 0, 2 => null], $newArray);
		Assert::same([3 => 'three', 4 => false, 5 => 'five', 6 => '', 7 => '0'], $array);

		$newArray = Arrays::keysUnset($array, 'foo');
		Assert::same([], $newArray);
	}


	public function testIntesectKeys(): void
	{
		$array = [1 => 0, 2 => null, 3 => 'three', 4 => false, 5 => 'five', 6 => '', 7 => '0'];
		Assert::same([2 => null, 3 => 'three', 5 => 'five'], Arrays::intersectKeys($array, [2, 3, 5]));
	}

}

(new ArraysTest())->run();
