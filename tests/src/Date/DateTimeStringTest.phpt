<?php

namespace h4kuna\DataType\Date;

use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';

class DateTimeStringTest extends \Tester\TestCase
{

	public function testRightDate()
	{
		Assert::same('2018-01-01 00:00:00', (string) DateTimeString::from('d.m.Y', '1.1.2018'));
	}

	public function testRightDataTime()
	{
		Assert::same('2018-01-01 12:33:12', (string) DateTimeString::from('d.m.Y H:i:s', '1.1.2018 12:33:12'));
	}

	public function testShortYear()
	{
		Assert::same('2008-01-01 00:00:00', (string) DateTimeString::from('d.m.y', '1.1.08'));
		Assert::same('2008-01-01 00:00:00', (string) DateTimeString::from('d.m.y', '1.1.8'));
		Assert::same('2018-01-01 00:00:00', (string) DateTimeString::from('d.m.y', '1.1.18'));
	}

	/**
	 * @throws \InvalidArgumentException
	 */
	public function testThrowManyDays()
	{
		DateTimeString::from('d.m.Y j', '28.2.2018 28');
	}

	/**
	 * @throws \InvalidArgumentException
	 */
	public function testThrowNotCompleteDate()
	{
		DateTimeString::from('d.m.', '28.2.');
	}

	public function testInvalidDate()
	{
		Assert::null(DateTimeString::from('d.m.Y', '29.2.2018'));
		Assert::null(DateTimeString::from('d.m.Y', '29.2.'));
		Assert::null(DateTimeString::from('d.m.Y', '28.2.18'));
	}
}

class MyDatetime extends \DateTime
{

	public function __toString()
	{
		return $this->format('Y-m-d H:i:s');
	}
}

DateTimeString::setClass(MyDatetime::class);

(new DateTimeStringTest)->run();