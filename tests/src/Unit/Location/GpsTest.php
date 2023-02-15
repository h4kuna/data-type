<?php declare(strict_types=1);

namespace h4kuna\DataType\Tests\Unit\Location;

use h4kuna;
use h4kuna\DataType;
use h4kuna\DataType\Location\Gps;
use Tester;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @testCase
 */
final class GpsTest extends Tester\TestCase
{

	public function testFromString(): void
	{
		$expected = [50.0835494, 14.4341414, 'lat' => 50.0835494, 'long' => 14.4341414];
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

		$expected = [-50.0835494, 14.4341414, 'lat' => -50.0835494, 'long' => 14.4341414];
		Assert::same($expected, self::round7(Gps::fromString('50.0835494S, 14.4341414E')));

		$expected = [50.0835494, -14.4341414, 'lat' => 50.0835494, 'long' => -14.4341414];
		Assert::same($expected, self::round7(Gps::fromString('50.0835494N, 14.4341414W')));

		$expected = [-50.0835494, -14.4341414, 'lat' => -50.0835494, 'long' => -14.4341414];
		Assert::same($expected, self::round7(Gps::fromString('50.0835494S, 14.4341414W')));
	}


	/**
	 * @throws h4kuna\DataType\Exceptions\InvalidArgumentsException
	 */
	public function testFromStringFail(): void
	{
		Gps::fromString('Hello fail');
	}


	/**
	 * @throws h4kuna\DataType\Exceptions\InvalidArgumentsException
	 */
	public function testPoleFail(): void
	{
		Gps::fromString('50.0835494A, 14.4341414W');
	}


	/**
	 * @param array<int|float> $coordinate
	 * @return array<float>
	 */
	private static function round7(array $coordinate): array
	{
		foreach ($coordinate as $k => $v) {
			$coordinate[$k] = round(floatval($v), 7);
		}

		return $coordinate;
	}

}

(new GpsTest())->run();
