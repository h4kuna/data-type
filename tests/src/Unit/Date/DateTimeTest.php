<?php declare(strict_types=1);

namespace h4kuna\DataType\Tests\Unit\Date;

use DateTime;
use h4kuna\DataType\Date;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../../bootstrap.php';

/**
 * @testCase
 */
final class DateTimeTest extends TestCase
{
	/**
	 * @return array<array<mixed>>
	 */
	public function provideMakeFromString(): array
	{
		return [
			['expected' => '2023-06-11 07:00:00', 'input' => ''],
			['expected' => self::format(new DateTime()), 'input' => 'now'],
			['expected' => '2023-06-11 07:00:00', 'input' => '0'],
			['expected' => '2023-06-11 07:30:00', 'input' => '0.5'], // decimal number has same behavior with or without +
			['expected' => '2023-06-11 07:30:00', 'input' => '+0.5'],
			['expected' => '2023-06-11 07:30:00', 'input' => '+0,5'],
			['expected' => '2023-06-11 06:30:00', 'input' => '-0,5'],
			['expected' => '2023-06-11 05:30:00', 'input' => '-1,5'],
			['expected' => '2023-06-11 08:00:00', 'input' => '+1'],
			['expected' => '2023-06-11 17:00:00', 'input' => '+10'],
			['expected' => '2023-06-11 10:00:00', 'input' => '10'],
			['expected' => '2023-06-10 21:00:00', 'input' => '-10'],
			['expected' => '2023-06-11 07:45:00', 'input' => '7:45'],
			['expected' => '2023-06-11 14:45:00', 'input' => '+7:45'],
			['expected' => '2023-06-11 05:30:00', 'input' => '5:30'],
			['expected' => '2023-06-12 06:45:00', 'input' => '12.6. 6:45'],
			['expected' => '2024-06-12 06:45:00', 'input' => '12.6.2024 6:45'],
			['expected' => '2023-06-11 07:00:00', 'input' => '2023-06-11 7:00'],
		];
	}


	/**
	 * @dataProvider provideMakeFromString
	 */
	public function testMakeFromString(string $expected, string $input): void
	{
		Assert::same($expected, self::format(Date\DateTime::fromString($input, new DateTime('2023-06-11 07:00:00'))));
	}


	private static function format(DateTime $dateTime): string
	{
		return $dateTime->format('Y-m-d H:i:s');
	}

}

(new DateTimeTest())->run();
