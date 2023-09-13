<?php declare(strict_types=1);

namespace h4kuna\DataType\Tests\Unit\Iterators;

use h4kuna\DataType\Iterators\PeriodDayFactory;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

/**
 * @testCase
 */
final class PeriodDayFactoryTest extends TestCase
{

	/**
	 * @dataProvider provideCreatePeriod
	 */
	public function testCreatePeriod(
		\Closure $case,
		string $to = '2023-01-02',
		?string $expectedFirst = null,
		?string $expectedLast = null
	): void
	{
		$classes = [\DateTimeImmutable::class, \DateTime::class];
		foreach ($classes as $class) {
			$startDate = new $class('2023-01-01 07:00:00');
			$endDate = new $class("$to 08:00:00");
			$period = $case($startDate, $endDate);
			assert($period instanceof \DatePeriod);

			$last = $first = null;
			$count = 0;
			foreach ($period as $date) {
				assert($date instanceof $class);
				if ($first === null) {
					$first = $date;
				}
				$last = $date;
				++$count;
			}

			$expectedLast ??= $expectedFirst;

			if ($expectedFirst === null && $expectedLast === null) {
				$expectedCount = 0;
				Assert::null($first);
				Assert::null($last);
			} else {
				assert($expectedFirst !== null && $expectedLast !== null && $last !== null && $first !== null);
				Assert::same($expectedFirst, $first->format('Y-m-d'));
				Assert::same($expectedLast, $last->format('Y-m-d'));
				$days = (new \DateTime($expectedLast))->diff(new \DateTime($expectedFirst))->days;
				assert($days !== false);
				$expectedCount = $days + 1;
			}

			Assert::same($expectedCount, $count);
		}
	}


	/**
	 * @return array<array<string, mixed>>
	 */
	public static function provideCreatePeriod(): array
	{
		return [
			['case' => fn(...$in) => PeriodDayFactory::createExFromInTo(...$in), 'expectedFirst' => '2023-01-02'],
			['case' => fn(...$in) => PeriodDayFactory::createExFromExTo(...$in)],
			['case' => fn(...$in) => PeriodDayFactory::createInFromInTo(...$in), 'expectedFirst' => '2023-01-01', 'expectedLast' => '2023-01-02'],
			['case' => fn(...$in) => PeriodDayFactory::createInFromExTo(...$in), 'expectedFirst' => '2023-01-01'],
			['case' => fn(...$in) => PeriodDayFactory::createExFromInTo(...$in), 'expectedFirst' => '2023-01-02', 'expectedLast' => '2023-01-03', 'to' => '2023-01-03'],
			['case' => fn(...$in) => PeriodDayFactory::createExFromExTo(...$in), 'expectedFirst' => '2023-01-02', 'to' => '2023-01-03'],
			['case' => fn(...$in) => PeriodDayFactory::createInFromInTo(...$in), 'expectedFirst' => '2023-01-01', 'expectedLast' => '2023-01-03', 'to' => '2023-01-03'],
			['case' => fn(...$in) => PeriodDayFactory::createInFromExTo(...$in), 'expectedFirst' => '2023-01-01', 'expectedLast' => '2023-01-02', 'to' => '2023-01-03'],
		];
	}

}

(new PeriodDayFactoryTest())->run();
