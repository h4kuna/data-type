<?php declare(strict_types=1);

namespace h4kuna\DataType\Tests\Unit\Date;

use DateTime;
use DateTimeInterface;
use h4kuna\DataType\Date\Calendar;
use h4kuna\DataType\Exceptions\InvalidArgumentsException;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @testCase
 */
final class CalendarTest extends \Tester\TestCase
{

	public function testGetDays(): void
	{
		Assert::same(Calendar::getDays(), Calendar::getDays());
	}


	public function testGetMonths(): void
	{
		Assert::same(Calendar::getMonths(), Calendar::getMonths());
	}


	/**
	 * @return array<array<mixed>>
	 */
	protected function provideNameOfDay(): array
	{
		return [
			['Pondělí', 1],
			['Úterý', 2],
			['Středa', 3],
			['Čtvrtek', '04'],
			['Pátek', '5'],
			['Sobota', new DateTime('2023-09-16')],
			['Neděle', 7],
			['Neděle', 0],
			[Calendar::getDays()[(date('w') === '0' ? 7 : date('w'))], null],
			[InvalidArgumentsException::class, 8],
			[InvalidArgumentsException::class, 'a'],
		];
	}


	/**
	 * @dataProvider provideNameOfDay
	 * @param null|int<0, 7>|string|DateTimeInterface $input
	 */
	public function testNameOfDay(string $expected, null|int|string|DateTimeInterface $input): void
	{
		if ($expected === InvalidArgumentsException::class) {
			Assert::exception(
				static fn () => Calendar::nameOfDay($input),
				$expected
			);
			return;
		}
		Assert::same($expected, Calendar::nameOfDay($input));
	}


	/**
	 * @return array<array<mixed>>
	 */
	protected function provideNameOfMonth(): array
	{
		return [
			['Leden', 1],
			['Únor', 2],
			['Březen', 3],
			['Duben', '04'],
			['Květen', '5'],
			['Červen', new DateTime('2023-06-16')],
			['Červenec', 7],
			['Srpen', 8],
			['Září', 9],
			['Říjen', 10],
			['Listopad', 11],
			['Prosinec', 12],
			[Calendar::getMonths()[date('n')], null],
			[InvalidArgumentsException::class, 13],
			[InvalidArgumentsException::class, 'a'],
		];
	}


	/**
	 * @dataProvider provideNameOfMonth
	 * @param null|int<1, 12>|string|DateTimeInterface $input
	 */
	public function testNameOfMonth(string $expected, null|int|string|DateTimeInterface $input): void
	{
		if ($expected === InvalidArgumentsException::class) {
			Assert::exception(
				static fn () => Calendar::nameOfMonth($input),
				$expected
			);
			return;
		}
		Assert::same($expected, Calendar::nameOfMonth($input));
	}


	public function testCzech2DateTime(): void
	{
		$format = 'Y-m-d';
		$dt = Calendar::czech2DateTime('1.1.1986');
		Assert::same('1986-01-01', $dt->format($format));

		$dt = Calendar::czech2DateTime('01.1.1986');
		Assert::same('1986-01-01', $dt->format($format));

		$dt = Calendar::czech2DateTime('01.01.1986');
		Assert::same('1986-01-01', $dt->format($format));

		$dt = Calendar::czech2DateTime('30.12.1986');
		Assert::same('1986-12-30', $dt->format($format));

		$format .= ' H:i:s';
		$dt = Calendar::czech2DateTime('01.01.1986 01:01:01');
		Assert::same('1986-01-01 01:01:01', $dt->format($format));

		$dt = Calendar::czech2DateTime('01.01.1986 1:1:1');
		Assert::same('1986-01-01 01:01:01', $dt->format($format));

		$dt = Calendar::czech2DateTime('01.01.1986 1:01:01');
		Assert::same('1986-01-01 01:01:01', $dt->format($format));

		$dt = Calendar::czech2DateTime('30.12.1986 23:59:59');
		Assert::same('1986-12-30 23:59:59', $dt->format($format));

		$dt = Calendar::czech2DateTime('30.12.1986 23:59');
		Assert::same('1986-12-30 23:59:00', $dt->format($format));

		Assert::exception(static fn () => Calendar::czech2DateTime('55646asd5464'), InvalidArgumentsException::class);
	}


	public function testFebruaryOfDay(): void
	{
		$years = [2012 => 29, 2013 => 28, 2014 => 28, 2015 => 28, 2016 => 29];
		foreach ($years as $year => $days) {
			Assert::same($days, Calendar::februaryOfDay($year));
		}

		Assert::same(29, Calendar::februaryOfDay(new DateTime('2016-02-02')));
	}


	public function testGetName(): void
	{
		Assert::same('Milan', Calendar::nameByDate(new DateTime('2013-06-18')));
		Assert::same(Calendar::nameByDate(), Calendar::nameByDate(new DateTime()));
	}


	public function testAllNames(): void
	{
		$interval = new \DatePeriod(new DateTime('01-01-2016'), new \DateInterval('P1D'), new DateTime('31-12-2016'));
		$i = 1;
		foreach ($interval as $item) {
			++$i;
			Assert::type('string', Calendar::nameByDate($item));
		}
		Assert::same(366, $i);
	}

}

(new CalendarTest())->run();
