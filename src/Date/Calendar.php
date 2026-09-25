<?php declare(strict_types = 1);

namespace h4kuna\DataType\Date;

use DateTimeImmutable;
use DateTimeInterface;
use h4kuna\DataType\Exceptions\InvalidArgumentsException;
use Nette\StaticClass;
use Nette\Utils\Strings;
use function checkdate;
use function date;
use function is_numeric;
use function sprintf;
use function trim;

final class Calendar
{

	use StaticClass;

	public static string $namesFile = __DIR__ . '/names.php';

	/**
	 * @var array<int, array<int, string>>|null
	 */
	private static ?array $names = null;


	private function __construct()
	{
	}

	/**
	 * @param int<0, 7>|string|DateTimeInterface|null $day
	 *
	 * @throws InvalidArgumentsException
	 */
	public static function nameOfDay(int|string|DateTimeInterface|null $day = null): string
	{
		if ($day === null) {
			$day = (int) date('w');
		} elseif ($day instanceof DateTimeInterface) {
			$day = (int) $day->format('w');
		} elseif (is_numeric($day)) {
			$day = (int) $day;
		} else {
			throw InvalidArgumentsException::createDayIsNotNumeric();
		}

		if ($day === 0) {
			$day = 7;
		}

		return self::getDays()[$day] ?? throw InvalidArgumentsException::createDayOutOfRange($day);
	}

	/**
	 * @return array<string>
	 */
	public static function getDays(): array
	{
		return [
			1 => 'Pondělí',
			'Úterý',
			'Středa',
			'Čtvrtek',
			'Pátek',
			'Sobota',
			'Neděle',
		];
	}

	/**
	 * @param int<1, 12>|string|DateTimeInterface|null $month
	 *
	 * @throws InvalidArgumentsException
	 */
	public static function nameOfMonth(int|string|DateTimeInterface|null $month = null): string
	{
		if ($month === null) {
			$month = (int) date('n');
		} elseif ($month instanceof DateTimeInterface) {
			$month = (int) $month->format('n');
		} elseif (is_numeric($month)) {
			$month = (int) $month;
		} else {
			throw InvalidArgumentsException::createMonthIsNotNumeric();
		}

		return self::getMonths()[$month] ?? throw InvalidArgumentsException::createMonthOutOfRange($month);
	}

	/**
	 * @return array<string>
	 */
	public static function getMonths(): array
	{
		return [
			1 => 'Leden',
			'Únor',
			'Březen',
			'Duben',
			'Květen',
			'Červen',
			'Červenec',
			'Srpen',
			'Září',
			'Říjen',
			'Listopad',
			'Prosinec',
		];
	}

	/**
	 * CZECH FORMAT DD.MM.YYYY[ HH:mm:SS]
	 *
	 * @throws InvalidArgumentsException
	 */
	public static function czech2DateTime(string $date): DateTimeImmutable
	{
		$find = Strings::match(trim($date), '/^(?P<d>[0-3]?\d)\.(?P<m>[0-1]?\d)\.(?P<y>\d{4})(?: +(?P<h>[0-6]?\d):(?P<i>[0-6]?\d)(?::(?P<s>[0-6]?\d))?)?$/');
		if ($find === null) {
			throw InvalidArgumentsException::createBadCzechDateFormat($date);
		}

		$find += ['h' => 0, 'i' => 0, 's' => 0];

		return new DateTimeImmutable(sprintf('%s-%s-%s %s:%s:%s', $find['y'], $find['m'], $find['d'], $find['h'], $find['i'], $find['s']));
	}

	public static function februaryOfDay(int|DateTimeInterface $year): int
	{
		if ($year instanceof DateTimeInterface) {
			$year = (int) $year->format('Y');
		}

		return checkdate(2, 29, $year) ? 29 : 28;
	}

	/**
	 * @param ?int<1970, 2037> $year
	 *
	 * @see Easter::monday()
	 * @deprecated see
	 */
	public static function easter(?int $year = null): DateTimeImmutable
	{
		return Easter::monday($year);
	}

	/**
	 * Return czech name on name-day.
	 *
	 * @throws InvalidArgumentsException
	 */
	public static function nameByDate(?DateTimeInterface $date = null): string
	{
		if ($date === null) {
			$date = new DateTimeImmutable();
		}
		$day = (int) $date->format('j');
		$month = (int) $date->format('n');

		return self::names()[$month][$day] ?? throw InvalidArgumentsException::createUnknownNameDay($month, $day);
	}

	/**
	 * @return array<int, array<int, string>>
	 */
	public static function names(): array
	{
		if (self::$names === null) {
			/** @var array<int, array<int, string>> $names */
			$names = require self::$namesFile;
			self::$names = $names;
		}

		return self::$names;
	}

}
