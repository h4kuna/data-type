<?php

namespace h4kuna\DataType\Basic;

use Tester\Assert;

include __DIR__ . '/../../bootstrap.php';

class ArraysTest extends \Tester\TestCase
{

	public function testCombine()
	{
		Assert::same([1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four'], Arrays::combine([1, 2, 3, 4], [
			'one',
			'two',
			'three',
			'four'
		]));

		Assert::same([1 => 'one', 2 => 'three', 3 => 'four', 4 => NULL], Arrays::combine([1, 2, 3, 4], [
			'one',
			'three',
			'four'
		]));

		Assert::same([1 => 'one', 2 => 'three', 3 => 'four', 4 => 'five'], Arrays::combine([1, 2, 3, 4], [
			'one',
			'three',
			'four'
		], 'five'));
	}

	/**
	 * @throws h4kuna\DataType\InvalidArgumentsException
	 */
	public function testCombineFail()
	{
		Arrays::combine([1, 2, 3, 4], ['one', 'two', 'three', 'four', 'five']);
	}

	public function testConcatWs()
	{
		$array = [1 => 0, 2 => NULL, 3 => 'three', 4 => FALSE, 5 => 'five', 6 => '', 7 => '0'];
		Assert::same('0|three|five|0', Arrays::concatWs('|', $array));
		Assert::same('five', Arrays::concatWs('|', $array, 2, 4, 5, 6));
		Assert::same('three|five', Arrays::concatWs('|', $array, 2, 3, 4, 5, 6));
		Assert::same('five', Arrays::concatWs('|', $array, 2, 5, 5, 6));
	}

	public function testCoalesce()
	{
		Assert::same('foo', Arrays::coalesce([NULL, FALSE, '', 'foo']));
		Assert::same('foo', Arrays::coalesce([NULL, FALSE, 'foo']));
		Assert::same('foo', Arrays::coalesce(['foo', NULL, FALSE]));
		Assert::same('foo', Arrays::coalesce(['bar', NULL, 'foo'], 1, 2));

		Assert::same(NULL, Arrays::coalesce([FALSE, NULL, '']));
		Assert::same(NULL, Arrays::coalesce([]));
		Assert::same(NULL, Arrays::coalesce([], 1));
	}

	public function testKeysUnset()
	{
		$array = [1 => 0, 2 => NULL, 3 => 'three', 4 => FALSE, 5 => 'five', 6 => '', 7 => '0'];
		$newArray = Arrays::keysUnset($array, 1, 2);
		Assert::same([1 => 0, 2 => NULL], $newArray);
		Assert::same([3 => 'three', 4 => FALSE, 5 => 'five', 6 => '', 7 => '0'], $array);

		$newArray = Arrays::keysUnset($array, 'foo');
		Assert::same([], $newArray);

		$arrayObject = new \ArrayIterator([
			1 => 0,
			2 => NULL,
			3 => 'three',
			4 => FALSE,
			5 => 'five',
			6 => '',
			7 => '0'
		]);
		$newArray = Arrays::keysUnset($arrayObject, 1, 2);
		Assert::same([1 => 0, 2 => NULL], $newArray);
		Assert::same([3 => 'three', 4 => FALSE, 5 => 'five', 6 => '', 7 => '0'], (array) $arrayObject);
	}

	public function testIntesectKeys()
	{
		$array = [1 => 0, 2 => NULL, 3 => 'three', 4 => FALSE, 5 => 'five', 6 => '', 7 => '0'];
		Assert::same([2 => NULL, 3 => 'three', 5 => 'five'], Arrays::intesectKeys($array, [2, 3, 5]));
	}

}

(new ArraysTest())->run();