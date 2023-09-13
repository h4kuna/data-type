<?php declare(strict_types=1);

namespace h4kuna\DataType\Tests\Unit\Date;

use DateTime;
use DateTimeImmutable;
use h4kuna\DataType\Date\Convert;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @testCase
 */
final class ConvertTest extends \Tester\TestCase
{

	public function testDateTime(): void
	{
		$dateTime = new DateTime();

		$newDateTime = Convert::toMutable($dateTime);
		Assert::equal($dateTime, $newDateTime);
		Assert::notSame($dateTime, $newDateTime);

		$newDateTime = Convert::toImmutable($dateTime);
		Assert::type(DateTimeImmutable::class, $newDateTime);
	}


	public function testDateTimeImmutable(): void
	{
		$dateTime = new DateTimeImmutable();

		$newDateTime = Convert::toImmutable($dateTime);
		Assert::same($dateTime, $newDateTime);

		$newDateTime = Convert::toMutable($dateTime);
		Assert::type(DateTime::class, $newDateTime);
	}


	public function testBySource(): void
	{
		Assert::type(DateTime::class, Convert::bySource(new DateTime(), new DateTime()));
		Assert::type(DateTime::class, Convert::bySource(new DateTime(), new DateTimeImmutable()));
		Assert::type(DateTimeImmutable::class, Convert::bySource(new DateTimeImmutable(), new DateTime()));
		Assert::type(DateTimeImmutable::class, Convert::bySource(new DateTimeImmutable(), new DateTimeImmutable()));
	}


	public function testDateTimeImmutableMidnight(): void
	{
		$dateTime = new DateTimeImmutable();

		$newDateTime = Convert::toImmutableMidnight($dateTime);
		Assert::same('00:00:00.000000', $newDateTime->format('H:i:s.u'));
		Assert::notSame($newDateTime->format('H:i:s.u'), $dateTime->format('H:i:s.u'));
	}

}

(new ConvertTest())->run();
