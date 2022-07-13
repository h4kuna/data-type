<?php

namespace h4kuna\DataType\Location;

use h4kuna\DataType,
	Tester\Assert;

include __DIR__ . '/../../bootstrap.php';

final class GpsTest extends \Tester\TestCase
{

	public function testFromString(): void
	{
		// Praha
		$expected = ['50.0835494', '14.4341414'];
		Assert::same($expected, self::round7(Gps::fromString('50.0835494N, 14.4341414E')));
		Assert::same($expected, self::round7(Gps::fromString('50.0835494, 14.4341414')));
		Assert::same($expected, self::round7(Gps::fromString("N 50°5.012965', E 14°26.048485'")));
		Assert::same($expected, self::round7(Gps::fromString('50°5\'0.778"N, 14°26\'2.909"E')));
		Assert::same($expected, self::round7(Gps::fromString('N50.0835494° E14.4341414°')));

		// no whitespace
		Assert::same($expected, self::round7(Gps::fromString('50.0835494N,14.4341414E')));
		Assert::same($expected, self::round7(Gps::fromString('50.0835494,14.4341414')));
		Assert::same($expected, self::round7(Gps::fromString("N50°5.012965',E14°26.048485'")));
		Assert::same($expected, self::round7(Gps::fromString('50°5\'0.778"N,14°26\'2.909"E')));
		Assert::same($expected, self::round7(Gps::fromString('N50.0835494°E14.4341414°')));

		$expected = ['-50.0835494', '14.4341414'];
		Assert::same($expected, self::round7(Gps::fromString('50.0835494S, 14.4341414E')));

		$expected = ['50.0835494', '-14.4341414'];
		Assert::same($expected, self::round7(Gps::fromString('50.0835494N, 14.4341414W')));

		$expected = ['-50.0835494', '-14.4341414'];
		Assert::same($expected, self::round7(Gps::fromString('50.0835494S, 14.4341414W')));
	}

	/**
	 * @throws \h4kuna\DataType\Exceptions\InvalidArgumentsException
	 */
	public function testFromStringFail(): void
	{
		Gps::fromString('Hello fail');
	}

	/**
	 * @throws \h4kuna\DataType\Exceptions\InvalidArgumentsException
	 */
	public function testPoleFail(): void
	{
		Gps::fromString('50.0835494A, 14.4341414W');
	}


	/**
	 * @param array<int|float> $coordinate
	 * @return array<string>
	 */
	private static function round7(array $coordinate): array
	{
		$out = [];
		foreach ($coordinate as $v) {
			$out[] = (string) round($v, 7);
		}
		return $out;
	}

}

(new GpsTest())->run();
