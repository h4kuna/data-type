<?php declare(strict_types=1);

namespace h4kuna\DataType\Tests\Unit\Iterators;

use Closure;
use DateTime;
use DateTimeImmutable;
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
		Closure $case,
		string $to = '2023-01-02',
		?string $expectedFirst = null,
		?string $expectedLast = null
	): void
	{
		$classes = [DateTimeImmutable::class, DateTime::class];
		foreach ($classes as $class) {
			$startDate = new $class('2023-01-01 07:00:00');
			$endDate = new $class("$to 08:00:00");
			$period = $case($startDate, $endDate);
			assert($period instanceof \DatePeriod);

			$dates = [];
			foreach ($period as $date) {
				Assert::type(DateTimeImmutable::class, $date);
				$dates[] = $date->format('Y-m-d');
			}

			$expectedLast ??= $expectedFirst;

			if ($expectedFirst === null || $expectedLast === null) {
				Assert::same([], $dates);
				continue;
			}

			Assert::same($expectedFirst, $dates[0] ?? null);
			Assert::same($expectedLast, $dates[count($dates) - 1] ?? null);
			$days = (new DateTime($expectedLast))->diff(new DateTime($expectedFirst))->days;
			Assert::same($days + 1, count($dates));
		}
	}


	/**
	 * @return array<array<string, mixed>>
	 */
	public static function provideCreatePeriod(): array
	{
		return [
			['case' => fn(DateTimeImmutable|DateTime $start, DateTimeImmutable|DateTime $end) => PeriodDayFactory::createExFromInTo($start, $end), 'expectedFirst' => '2023-01-02'],
			['case' => fn(DateTimeImmutable|DateTime $start, DateTimeImmutable|DateTime $end) => PeriodDayFactory::createExFromExTo($start, $end)],
			['case' => fn(DateTimeImmutable|DateTime $start, DateTimeImmutable|DateTime $end) => PeriodDayFactory::createInFromInTo($start, $end), 'expectedFirst' => '2023-01-01', 'expectedLast' => '2023-01-02'],
			['case' => fn(DateTimeImmutable|DateTime $start, DateTimeImmutable|DateTime $end) => PeriodDayFactory::createInFromExTo($start, $end), 'expectedFirst' => '2023-01-01'],
			['case' => fn(DateTimeImmutable|DateTime $start, DateTimeImmutable|DateTime $end) => PeriodDayFactory::createExFromInTo($start, $end), 'expectedFirst' => '2023-01-02', 'expectedLast' => '2023-01-03', 'to' => '2023-01-03'],
			['case' => fn(DateTimeImmutable|DateTime $start, DateTimeImmutable|DateTime $end) => PeriodDayFactory::createExFromExTo($start, $end), 'expectedFirst' => '2023-01-02', 'to' => '2023-01-03'],
			['case' => fn(DateTimeImmutable|DateTime $start, DateTimeImmutable|DateTime $end) => PeriodDayFactory::createInFromInTo($start, $end), 'expectedFirst' => '2023-01-01', 'expectedLast' => '2023-01-03', 'to' => '2023-01-03'],
			['case' => fn(DateTimeImmutable|DateTime $start, DateTimeImmutable|DateTime $end) => PeriodDayFactory::createInFromExTo($start, $end), 'expectedFirst' => '2023-01-01', 'expectedLast' => '2023-01-02', 'to' => '2023-01-03'],
		];
	}

}

(new PeriodDayFactoryTest())->run();
