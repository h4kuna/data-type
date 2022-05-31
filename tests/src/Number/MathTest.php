<?php

namespace h4kuna\DataType\Number;

use Tester\Assert;

include __DIR__ . '/../../bootstrap.php';

class MathTest extends \Tester\TestCase
{

	public function testInterval()
	{
		Assert::same(1, Math::interval(1, 2));
		Assert::same(1, Math::interval(1, 1));
		Assert::same(0, Math::interval(1, 0));

		Assert::same(2, Math::interval(2, 4, 1));
		Assert::same(2, Math::interval(2, 4, 2));
		Assert::same(3, Math::interval(2, 4, 3));

		Assert::same(-5, Math::interval(-5, -4, -6));
	}

	/**
	 * @throws \h4kuna\DataType\Exceptions\InvalidArgumentsException
	 */
	public function testIntervalFail()
	{
		Math::interval(2, 1, 3);
	}

	public function testRound5()
	{
		Assert::same(1.0, Math::round5(1.0));
		Assert::same(1.0, Math::round5(1.1));
		Assert::same(1.0, Math::round5(1.24));
		Assert::same(1.5, Math::round5(1.25));
		Assert::same(1.5, Math::round5(1.3));
		Assert::same(1.5, Math::round5(1.4));
		Assert::same(1.5, Math::round5(1.5));
		Assert::same(1.5, Math::round5(1.6));
		Assert::same(1.5, Math::round5(1.74));
		Assert::same(2.0, Math::round5(1.75));
		Assert::same(2.0, Math::round5(1.8));
		Assert::same(2.0, Math::round5(1.9));
		Assert::same(2.0, Math::round5(2));

		Assert::same(-1.0, Math::round5(-1.0));
		Assert::same(-1.0, Math::round5(-1.1));
		Assert::same(-1.0, Math::round5(-1.24));
		Assert::same(-1.5, Math::round5(-1.25));
		Assert::same(-1.5, Math::round5(-1.3));
		Assert::same(-1.5, Math::round5(-1.4));
		Assert::same(-1.5, Math::round5(-1.5));
		Assert::same(-1.5, Math::round5(-1.6));
		Assert::same(-1.5, Math::round5(-1.74));
		Assert::same(-2.0, Math::round5(-1.75));
		Assert::same(-2.0, Math::round5(-1.8));
		Assert::same(-2.0, Math::round5(-1.9));
		Assert::same(-2.0, Math::round5(-2));
	}

	public function testSafeDivision()
	{
		Assert::same(0, Math::safeDivision(0, 1));
		Assert::same(null, Math::safeDivision(1, 0));
		Assert::same(1, Math::safeDivision(1, 1));
	}

	public function testFactorial()
	{
		Assert::same(120, Math::factorial(5));
	}

	/**
	 * @throws \h4kuna\DataType\Exceptions\InvalidArgumentsException
	 */
	public function testFactorialFail()
	{
		Math::factorial(-1);
	}
}

(new MathTest())->run();
