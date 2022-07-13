<?php

namespace h4kuna\DataType\Basic;

use Tester\Assert;

include __DIR__ . '/../../bootstrap.php';

final class SetTest extends \Tester\TestCase
{

	public function testFromString(): void
	{
		$set = ['one' => true, 'two' => true, 'three' => true, 'four' => true, 'five' => true];
		$setString = implode(',', array_keys($set));

		Assert::same($set, Set::fromString($setString));
		Assert::same($setString, Set::toString($set));

		$set['three'] = false;
		Assert::same('one,two,four,five', Set::toString($set));
		unset($set['three']);
		Assert::same($set, Set::fromString('one,two,four,five'));
	}

}

(new SetTest())->run();
