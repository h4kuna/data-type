<?php declare(strict_types=1);

namespace h4kuna\DataType\Tests\Unit\Basic;

use h4kuna\DataType\Basic\BitwiseOperations;
use Tester;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @testCase
 */
final class BitwiseOperationsTest extends Tester\TestCase
{

	public function testCheck(): void
	{
		Assert::true(BitwiseOperations::check(3, 2));
		Assert::false(BitwiseOperations::check(3, 4));
	}


	public function testCheckStrict(): void
	{
		Assert::true(BitwiseOperations::checkStrict(2, 2));
		Assert::false(BitwiseOperations::checkStrict(3, 2));
		Assert::false(BitwiseOperations::checkStrict(3, 4));
	}


	public function testAdd(): void
	{
		$x = 2;
		BitwiseOperations::add($x, 4);
		Assert::same(6, $x);
	}


	public function testRemove(): void
	{
		$x = 6;
		BitwiseOperations::remove($x, 4);
		Assert::same(2, $x);
	}

}

(new BitwiseOperationsTest())->run();
