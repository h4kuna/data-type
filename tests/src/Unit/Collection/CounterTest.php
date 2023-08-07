<?php declare(strict_types=1);

namespace h4kuna\DataType\Tests\Unit\Collection;

use h4kuna\DataType\Collection\Counter;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @testCase
 */
final class CounterTest extends TestCase
{

	public function testSeconds(): void
	{
		$counter = new Counter(2);
		Assert::count(0, $counter);

		self::tick5($counter);
		Assert::count(5, $counter);
		sleep(1);

		self::tick5($counter);
		Assert::count(10, $counter);
		Assert::false($counter->isFull());
		sleep(1);

		Assert::true($counter->isFull());
		Assert::count(5, $counter);
		sleep(1);

		Assert::count(0, $counter);
	}


	public function testCountStack(): void
	{
		$counter = new Counter(-2);
		Assert::null($counter->last());

		$counter->tick('a');
		Assert::count(1, $counter);
		assert($counter->last() !== null);
		Assert::same('a', $counter->last()['message']);

		$counter->tick('b');
		Assert::false($counter->isFull());
		Assert::count(2, $counter);
		assert($counter->last() !== null);
		Assert::same('b', $counter->last()['message']);

		$counter->tick('c');
		Assert::true($counter->isFull());
		Assert::count(2, $counter);
		assert($counter->last() !== null);
		Assert::same('c', $counter->last()['message']);
	}


	private static function tick5(Counter $counter): void
	{
		for ($i = 0; $i < 5; ++$i) {
			$counter->tick();
		}
	}

}

(new CounterTest())->run();
