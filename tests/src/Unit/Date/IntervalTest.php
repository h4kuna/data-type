<?php

declare(strict_types=1);

namespace h4kuna\DataType\Tests\Unit\Date;

require __DIR__ . '/../../../bootstrap.php';

use Closure;
use DateInterval;
use DateTime;
use h4kuna\DataType\Date\Interval;
use Tester\Assert;
use Tester\TestCase;

final class IntervalTest extends TestCase
{
	/**
	 * @return array<string|int, array{0: Closure(static):void}>
	 */
	public static function dataToSeconds(): array
	{
		return [
			'29. february exists' => [
				static function (self $self) {
					$interval = (new DateTime('2023-06-01 00:00:00'))->diff(new DateTime('2024-06-01 12:13:14'));
					$self->assertToSeconds(31666394.0, $interval);
				},
			],
			'only 28. february' => [
				static function (self $self) {
					$interval = (new DateTime('2022-06-01 00:00:00'))->diff(new DateTime('2023-06-01 12:13:14'));
					$self->assertToSeconds(31579994.0, $interval);
				},
			],
			'only 28. february invert' => [
				static function (self $self) {
					$interval = (new DateTime('2023-06-01 12:13:14'))->diff(new DateTime('2022-06-01 00:00:00'));
					$self->assertToSeconds(-31579994.0, $interval);
				},
			],
			'miliseconds' => [
				static function (self $self) {
					$interval = (new DateTime('2022-06-01 00:00:00.55'))->diff(new DateTime('2023-06-01 12:13:14'));
					$self->assertToSeconds(31579993.45, $interval);
				},
			],
			'from string' => [
				static function (self $self) {
					$interval = (new DateInterval('P3Y6M4DT12H30M5S'));
					$self->assertToSeconds(110842205.0, $interval);
				},
			],
		];
	}


	/**
	 * @param Closure(static):void $assert
	 * @dataProvider dataToSeconds
	 */
	public function testToSeconds(Closure $assert): void
	{
		$assert($this);
	}


	public function assertToSeconds(
		float $expected,
		DateInterval $dateInterval,
	): void
	{
		Assert::same((int) round($expected), Interval::toSeconds($dateInterval));
		Assert::same($expected, Interval::toSecondsMilli($dateInterval));
	}
}

(new IntervalTest())->run();
