<?php

namespace h4kuna\DataType\Date;

use \DateTime,
	Tester\Assert;

include __DIR__ . '/../../bootstrap.php';

class CalendarTest extends \Tester\TestCase
{

	public function testGetDays()
	{
		Assert::same(Calendar::getDays(), Calendar::getDays());
	}

	public function testGetMonths()
	{
		Assert::same(Calendar::getMonths(), Calendar::getMonths());
	}

	public function testNameOfDay()
	{
		$days = Calendar::getDays();
		$today = (date('w') == 0 ? 7 : date('w'));
		Assert::same($days[$today], Calendar::nameOfDay());
		Assert::same($days[$today], Calendar::nameOfDay(date('w')));
		Assert::same($days[5], Calendar::nameOfDay(new DateTime('2016-12-30')));
	}

	/**
	 * @throws h4kuna\DataType\InvalidArgumentsException
	 */
	public function testNameOfDayFail()
	{
		Calendar::nameOfDay(8);
	}

	public function testNameOfMonth()
	{
		$days = Calendar::getMonths();
		$today = date('n');
		Assert::same($days[$today], Calendar::nameOfMonth());
		Assert::same($days[$today], Calendar::nameOfMonth(date('n')));
		Assert::same($days[12], Calendar::nameOfMonth(new DateTime('2016-12-30')));
	}

	/**
	 * @throws h4kuna\DataType\InvalidArgumentsException
	 */
	public function testNameOfMonthFail()
	{
		Calendar::nameOfMonth(13);
	}

	public function testCzech2DateTime()
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
	}

	public function testFebruaryOfDay()
	{
		$years = [2012 => 29, 2013 => 28, 2014 => 28, 2015 => 28, 2016 => 29];
		foreach ($years as $year => $days) {
			Assert::same($days, Calendar::februaryOfDay($year));
		}
	}

	public function testEaster()
	{
		$years = [
			2012 => '2012-04-09',
			2013 => '2013-04-01',
			2014 => '2014-04-21',
			2015 => '2015-04-06',
			2016 => '2016-03-28',
		];
		foreach ($years as $year => $days) {
			Assert::same($days, Calendar::easter($year)->format('Y-m-d'));
		}

		Assert::same(date('Y'), Calendar::easter()->format('Y'));
	}

	public function testGetName()
	{
		Assert::same('Milan', Calendar::getName(new DateTime('2013-06-18')));
		Assert::same(Calendar::getName(), Calendar::getName(new DateTime));
	}

	public function testAllNames()
	{
		$interval = new \DatePeriod(new \DateTime('01-01-2016'), new \DateInterval('P1D'), new \DateTime('31-12-2016'));
		$i = 1;
		foreach ($interval as $item) {
			++$i;
			Assert::true(is_string(Calendar::getName($item)));
		}
		Assert::same(366, $i);
	}
}

(new CalendarTest())->run();