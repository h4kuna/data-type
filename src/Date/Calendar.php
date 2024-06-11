<?php declare(strict_types=1);

namespace h4kuna\DataType\Date;

use DateTimeImmutable;
use DateTimeInterface;
use h4kuna\DataType;
use h4kuna\DataType\Exceptions\InvalidArgumentsException;
use h4kuna\Memoize\MemoryStorageStatic;
use Nette\StaticClass;
use Nette\Utils\Strings;

final class Calendar
{
	use StaticClass;
	use MemoryStorageStatic;

	public static string $namesFile = __DIR__ . '/names.php';


	private function __construct()
	{
	}


	/**
	 * @return array<string>
	 */
	public static function getDays(): array
	{
		return self::memoize(__METHOD__, static function () {
			return [
				1 => 'Pondělí',
				'Úterý',
				'Středa',
				'Čtvrtek',
				'Pátek',
				'Sobota',
				'Neděle',
			];
		});
	}


	/**
	 * @return array<string>
	 */
	public static function getMonths(): array
	{
		return self::memoize(__METHOD__, static function () {
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
		});
	}


	/**
	 * @param null|int<0, 7>|string|DateTimeInterface $day
	 */
	public static function nameOfDay(null|int|string|DateTimeInterface $day = null): string
	{
		if ($day === null) {
			$day = (int) date('w');
		} elseif ($day instanceof DateTimeInterface) {
			$day = (int) $day->format('w');
		} elseif (is_numeric($day)) {
			$day = (int) $day;
		} else {
			throw new InvalidArgumentsException('Input is allowed DateTimeInterface or numeric.');
		}

		if ($day === 0) {
			$day = 7;
		}

		return self::getDays()[$day] ?? throw new InvalidArgumentsException('Invalid number for day, interval is 0-6, 0 = Sunday');
	}

	/**
	 * @param null|int<1, 12>|string|DateTimeInterface $month
	 */
	public static function nameOfMonth(null|int|string|DateTimeInterface $month = null): string
	{
		if ($month === null) {
			$month = (int) date('n');
		} elseif ($month instanceof DateTimeInterface) {
			$month = (int) $month->format('n');
		} elseif (is_numeric($month)) {
			$month = (int) $month;
		} else {
			throw new InvalidArgumentsException('Input is allowed DateTimeInterface or numeric');
		}

		return self::getMonths()[$month] ?? throw new InvalidArgumentsException('Invalid number for day, interval is 1-12.');
	}


	/**
	 * CZECH FORMAT DD.MM.YYYY[ HH:mm:SS]
	 */
	public static function czech2DateTime(string $date): DateTimeImmutable
	{
		$find = Strings::match(trim($date), '/^(?P<d>[0-3]?\d)\.(?P<m>[0-1]?\d)\.(?P<y>\d{4})(?: +(?P<h>[0-6]?\d):(?P<i>[0-6]?\d)(?::(?P<s>[0-6]?\d))?)?$/');
		if ($find === null) {
			throw new InvalidArgumentsException('Bad czech date format. ' . $date);
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
	 * @deprecated see
	 * @see Easter::monday()
	 * @param ?int<1970, 2037> $year
	 */
	public static function easter(?int $year = null): DateTimeImmutable
	{
		return Easter::monday($year);
	}


	/**
	 * Return czech name on name-day.
	 */
	public static function nameByDate(?DateTimeInterface $date = null): string
	{
		if ($date === null) {
			$date = new DateTimeImmutable();
		}
		$day = (int) $date->format('j');
		$month = (int) $date->format('n');

		return self::names()[$month][$day] ?? throw new InvalidArgumentsException(sprintf('Bad month "%s" or day "%s".', $month, $day));
	}


	/**
	 * @return array<int, array<int, string>>
	 */
	public static function names(): array
	{
		return self::memoize(__METHOD__, static fn () => require_once self::$namesFile);
	}
}
