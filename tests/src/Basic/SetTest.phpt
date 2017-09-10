<?php

namespace h4kuna\DataType\Basic;

use Tester\Assert;

include __DIR__ . '/../../bootstrap.php';

class SetTest extends \Tester\TestCase
{

	public function testFromString()
	{
		$set = ['one' => TRUE, 'two' => TRUE, 'three' => TRUE, 'four' => TRUE, 'five' => TRUE];
		$setString = implode(',', array_keys($set));

		Assert::same($set, Set::fromString($setString));
		Assert::same($setString, Set::toString($set));

		$set['three'] = FALSE;
		Assert::same('one,two,four,five', Set::toString($set));
		unset($set['three']);
		Assert::same($set, Set::fromString('one,two,four,five'));
	}

	/**
	 * @throws \h4kuna\DataType\InvalidArgumentsException
	 */
	public function testFromStringFail()
	{
		Set::fromString([]);
	}
}

(new SetTest())->run();