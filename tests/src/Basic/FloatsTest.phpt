<?php

namespace h4kuna\DataType\Basic;

use h4kuna\DataType,
	Tester\Assert;

include __DIR__ . '/../../bootstrap.php';

class FloatsTest extends \Tester\TestCase
{

	public function testFromString()
	{
		Assert::same(0.0, Floats::fromString('0'));
		Assert::same(0.0, Floats::fromString('0.0'));
		Assert::same(0.0, Floats::fromString('-0.0'));
		Assert::same(0.0, Floats::fromString('-.0'));
		Assert::same(0.0, Floats::fromString('-0.'));

		Assert::same(-1.0, Floats::fromString(-1));
		Assert::same(-1.0, Floats::fromString(-1.0));
		Assert::same(-1.0, Floats::fromString('-1'));
		Assert::same(-1.0, Floats::fromString('-1.0'));
		Assert::same(-1.0, Floats::fromString('-1,0'));
		Assert::same(-1.0, Floats::fromString(' - 1 , 0 '));

		Assert::same(1.5, Floats::fromString('1:30'));
	}

	/**
	 * @throws h4kuna\DataType\InvalidArgumentsException
	 */
	public function testExceptionFloatNull()
	{
		Floats::fromString(NULL);
	}

	/**
	 * @throws \h4kuna\DataType\InvalidArgumentsException
	 */
	public function testExceptionFloatChar()
	{
		Assert::same(-1.0, Floats::fromString('-1,d0'));
	}

	public function testFromHour()
	{
		Assert::same(0.0, Floats::fromHour('0:0:0'));
		Assert::same(1.5, Floats::fromHour('1:30'));
		Assert::same(1.5, Floats::fromHour('1:30:0'));
		Assert::same(1.5083, round(Floats::fromHour('1:30:30'), 4));
	}

}

(new FloatsTest())->run();