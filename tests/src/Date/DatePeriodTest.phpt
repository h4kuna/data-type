<?php

namespace h4kuna\DataType\Date;

use Tester\Assert;

include __DIR__ . '/../../bootstrap.php';

class DatePeriodTest extends \Tester\TestCase
{

	public function testDefault()
	{
		$period = DatePeriod::create('2017-10-10', '2017-10-12');
		$count = 0;
		foreach ($period as $date) {
			++$count;
		}

		Assert::same(3, $count);

		// seconds
		$period = DatePeriod::create('2017-10-10 00:00:00', '2017-10-10 00:01:00', '1 second');
		$count = 0;
		foreach ($period as $date) {
			++$count;
		}

		Assert::same(61, $count);
	}


	public function testOptions()
	{
		$period = DatePeriod::create('2017-10-10', '2017-10-12', null, 0);
		$count = 0;
		foreach ($period as $date) {
			++$count;
		}

		Assert::same(2, $count);
	}



}

(new DatePeriodTest())->run();