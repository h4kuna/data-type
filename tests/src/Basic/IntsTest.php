<?php

namespace h4kuna\DataType\Basic;

use Tester\Assert;

include __DIR__ . '/../../bootstrap.php';

final class IntsTest extends \Tester\TestCase
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
	 * @throws \h4kuna\DataType\Exceptions\InvalidArgumentsException
	 */
	public function testFailed(): void
	{
		Assert::same(1, Ints::fromString('1.1')); // not int
	}

}

(new IntsTest())->run();
