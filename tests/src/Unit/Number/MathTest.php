<?php declare(strict_types=1);

namespace h4kuna\DataType\Tests\Unit\Number;

use DateTime;
use h4kuna;
use h4kuna\DataType\Number\Math;
use Tester;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @testCase
 */
final class MathTest extends Tester\TestCase
{

	public function testInterval(): void
	{
		Assert::same(1, Math::interval(1, 2));
		Assert::same(1, Math::interval(1, 1));
		Assert::same(0, Math::interval(1, 0));

		Assert::same(2, Math::interval(2, 4, 1));
		Assert::same(2, Math::interval(2, 4, 2));
		Assert::same(3, Math::interval(2, 4, 3));
		Assert::same(2, Math::interval(2, 4, null));
		Assert::same(4, Math::interval(5, 4, null));
		Assert::same(2, Math::interval(2, null, 1));
		Assert::same(6, Math::interval(5, null, 6));
		Assert::same(5, Math::interval(5, null, null));

		Assert::same(-5, Math::interval(-5, -4, -6));

		Assert::same(3.0, Math::interval(2.0, 4.0, 3.0));

		$min = new DateTime('1986-12-30 00:00:00');
		Assert::same($min, Math::interval(new DateTime('1986-12-29 23:59:59'), new DateTime('1986-12-31 00:00:00'), $min));

		$max = new DateTime('1986-12-31 00:00:00');
		Assert::same($max, Math::interval(new DateTime('1986-12-31 00:00:01'), $max, new DateTime('1986-12-30 00:00:00')));
	}

	/**
	 * @throws h4kuna\DataType\Exceptions\InvalidArgumentsException
	 */
	public function testIntervalFail(): void
	{
		Math::interval(2, 1, 3);
	}

	public function testRound5(): void
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

	public function testSafeDivision(): void
	{
		Assert::same(0.0, Math::safeDivision(0, 1));
		Assert::same(null, Math::safeDivision(1, 0));
		Assert::same(1.0, Math::safeDivision(1, 1));
	}

	public function testFactorial(): void
	{
		Assert::same(120, Math::factorial(5));
	}

	/**
	 * @throws \h4kuna\DataType\Exceptions\InvalidArgumentsException
	 */
	public function testFactorialFail(): void
	{
		Math::factorial(-1);
	}
}

(new MathTest())->run();
