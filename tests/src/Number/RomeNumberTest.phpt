<?php

namespace h4kuna\DataType\Number;

use h4kuna\DataType,
	Tester\Assert;

include __DIR__ . '/../../bootstrap.php';

class RomeNumberTest extends \Tester\TestCase
{

	public function testArabic()
	{
		Assert::same(1090, RomeNumber::getArabic('MXC'));
	}


	public function testRome()
	{
		Assert::same('MXC', RomeNumber::getRome(1090));
	}
}

(new RomeNumberTest())->run();