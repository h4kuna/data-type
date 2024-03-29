<?php declare(strict_types=1);

namespace h4kuna\DataType\Tests\Unit\Basic;

use h4kuna;
use h4kuna\DataType\Basic\Floats;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @testCase
 */
final class FloatsTest extends \Tester\TestCase
{

	public function testFromString(): void
	{
		Assert::same(0.0, Floats::from('0'));
		Assert::same(0.0, Floats::from('0.0'));
		Assert::same(0.0, Floats::from('-0.0'));
		Assert::same(0.0, Floats::from('-.0'));
		Assert::same(0.0, Floats::from('-0.'));
		Assert::same(0.0, Floats::from(''));
		Assert::same(0.0, Floats::from(null));
		Assert::same(1.0, Floats::from(true));
		Assert::same(0.0, Floats::from(false));

		Assert::same(-1.0, Floats::from(-1));
		Assert::same(-1.0, Floats::from(-1.0));
		Assert::same(-1.0, Floats::from('-1'));
		Assert::same(-1.0, Floats::from('-1.0'));
		Assert::same(-1.0, Floats::from('-1,0'));
		Assert::same(-1.0, Floats::from(' - 1 , 0 '));

		Assert::same(1.5, Floats::from('1:30'));
	}


	/**
	 * @throws h4kuna\DataType\Exceptions\InvalidTypeException
	 */
	public function testExceptionFloatChar(): void
	{
		Assert::same(-1.0, Floats::from('-1,d0'));
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
		Assert::same(3620.0, Floats::from('3.620,00', ',', '.'));
	}

}

(new FloatsTest())->run();
