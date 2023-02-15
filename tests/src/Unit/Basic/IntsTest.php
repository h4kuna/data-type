<?php declare(strict_types=1);

namespace h4kuna\DataType\Tests\Unit\Basic;

use h4kuna;
use h4kuna\DataType\Basic\Ints;
use Tester;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @testCase
 */
final class IntsTest extends Tester\TestCase
{

	public function testFromString(): void
	{
		Assert::same(1, Ints::fromString(1));
		Assert::same(1, Ints::fromString('1.0'));
		Assert::same(1, Ints::fromString('1'));
		Assert::same(1, Ints::fromString(' 1 '));
		Assert::same(-1000, Ints::fromString('- 1 000'));
	}


	/**
	 * @throws h4kuna\DataType\Exceptions\InvalidArgumentsException
	 */
	public function testFailed(): void
	{
		Assert::same(1, Ints::fromString('1.1')); // not int
	}

}

(new IntsTest())->run();
