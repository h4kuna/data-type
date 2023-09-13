<?php declare(strict_types=1);

namespace h4kuna\DataType\Tests\Unit\Date;

use h4kuna\DataType\Date\Sleep;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @testCase
 */
final class SleepTest extends TestCase
{

	public function testSeconds(): void
	{
		$start = microtime(true);
		Sleep::seconds(0.5);
		Assert::same(0.5, round(microtime(true) - $start, 1));
	}


	public function testMilliseconds(): void
	{
		$start = microtime(true);
		Sleep::milliseconds(500);
		Assert::same(0.5, round(microtime(true) - $start, 1));
	}

}

(new SleepTest())->run();
