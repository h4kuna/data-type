<?php

namespace h4kuna\DataType\Basic;

use Tester\Assert;

include __DIR__ . '/../../bootstrap.php';

final class FloatsTest extends \Tester\TestCase
{

	public function testFromString(): void
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
	 * @throws \h4kuna\DataType\Exceptions\InvalidArgumentsException
	 */
	public function testExceptionFloatNull(): void
	{
		Floats::fromString('');
	}

	/**
	 * @throws \h4kuna\DataType\Exceptions\InvalidArgumentsException
	 */
	public function testExceptionFloatChar(): void
	{
		Assert::same(-1.0, Floats::fromString('-1,d0'));
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
		Assert::same(3620.0, Floats::fromString('3.620,00', ',', '.'));
	}

}

(new FloatsTest())->run();
