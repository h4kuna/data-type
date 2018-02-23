<?php

namespace h4kuna\DataType\Date;

use DateTime,
	h4kuna\DataType;

/**
 * @author Milan Matějček
 */
final class Calendar
{

	/**
	 * Cache
	 * @var array
	 */
	private static $date = [];

	private function __construct() { }

	/**
	 * Czech days prepare for translate.
	 * @return string[]
	 */
	public static function getDays()
	{
		if (!isset(self::$date['days'])) {
			self::$date['days'] = array(1 => _('Pondělí'), _('Úterý'), _('Středa'), _('Čtvrtek'), _('Pátek'), _('Sobota'), _('Neděle'));
		}
		return self::$date['days'];
	}

	/**
	 * Czech months prepare for translate.
	 * @return string[]
	 */
	public static function getMonths()
	{
		if (!isset(self::$date['months'])) {
			self::$date['months'] = array(1 => _('Leden'), _('Únor'), _('Březen'), _('Duben'), _('Květen'), _('Červen'),
				_('Červenec'), _('Srpen'), _('Září'), _('Říjen'), _('Listopad'), _('Prosinec'));
		}
		return self::$date['months'];
	}

	/**
	 * NULL - actual day.
	 * 0 (for Sunday) through 6 (for Saturday)
	 * @param NULL|Ints|DateTime $day
	 * @return string
	 * @throws DataType\InvalidArgumentsException
	 */
	public static function nameOfDay($day = null)
	{
		$days = self::getDays();
		if ($day === null) {
			$day = (int) date('w');
		} elseif ($day instanceof DateTime) {
			$day = (int) $day->format('w');
		} elseif (is_numeric($day)) {
			$day = (int) $day;
		} else {
			throw new DataType\InvalidArgumentsException('Input is allowed Datetime, int');
		}

		if (!$day) {
			$day = 7;
		}

		if (isset($days[$day])) {
			return $days[$day];
		}

		throw new DataType\InvalidArgumentsException('Invalid number for day, interval is 0-6, 0 = Sunday');
	}

	/**
	 * Name of month.
	 * @param NULL|Ints|DateTime $month
	 * @return string
	 * @throws DataType\InvalidArgumentsException
	 */
	public static function nameOfMonth($month = null)
	{
		$months = self::getMonths();

		if ($month === null) {
			$month = (int) date('n');
		} elseif ($month instanceof DateTime) {
			$month = (int) $month->format('n');
		} elseif (is_numeric($month)) {
			$month = (int) $month;
		} else {
			throw new DataType\InvalidArgumentsException('Input is allowed Datetime, int');
		}

		if (isset($months[$month])) {
			return $months[$month];
		}

		throw new DataType\InvalidArgumentsException('Invalid number for day, interval is 1-12.');
	}

	/**
	 * @param string $date CZECH FORMAT DD.MM.YYYY[ HH:mm:SS]
	 * @return DateTime
	 * @throws DataType\InvalidArgumentsException
	 */
	public static function czech2DateTime($date)
	{
		if (!preg_match('/^(?P<d>[0-3]?\d)\.(?P<m>[0-1]?\d)\.(?P<y>\d{4})(?: +(?P<h>[0-6]?\d):(?P<i>[0-6]?\d)(?::(?P<s>[0-6]?\d))?)?$/', trim($date), $find)) {
			throw new DataType\InvalidArgumentsException('Bad czech date format. ' . $date);
		}

		$dt = new DateTime($find['y'] . '-' . $find['m'] . '-' . $find['d'] . ' 00:00:00');
		if (isset($find['h'])) {
			$find += ['s' => 0];
			$dt->setTime($find['h'], $find['i'], $find['s']);
		}
		return $dt;
	}

	/**
	 * Number days of February.
	 * @param Ints|DateTime $year
	 * @return Ints
	 */
	public static function februaryOfDay($year)
	{
		if ($year instanceof DateTime) {
			$year = $year->format('Y');
		}
		return checkdate(2, 29, $year) ? 29 : 28;
	}

	/**
	 * Easter monday.
	 * @param Ints $year 1970-2037
	 * @return DateTime
	 */
	public static function easter($year = null)
	{
		if ($year === null) {
			$year = date('Y');
		}
		$dt = new DateTime;
		$dt->setTimestamp(easter_date($year));
		$dt->setTime(0, 0, 0);
		$dt->modify('next monday');
		return $dt;
	}

	/**
	 * Return czech name on name-day.
	 * @param DateTime $day
	 * @param Ints|NULL $month
	 * @return string
	 * @throws DataType\InvalidArgumentsException
	 */
	public static function getName(DateTime $date = null)
	{
		if ($date === null) {
			$date = new DateTime;
		}
		$day = $date->format('d');

		switch ($date->format('m')) {
			case 1:
				switch ($day) {
					case 1: return 'Nový rok';
					case 2: return 'Karina';
					case 3: return 'Radmila';
					case 4: return 'Diana';
					case 5: return 'Dalimil';
					case 6: return 'Tři králové';
					case 7: return 'Vilma';
					case 8: return 'Čestmír';
					case 9: return 'Vladan';
					case 10: return 'Břetislav';
					case 11: return 'Bohdana';
					case 12: return 'Pravoslav';
					case 13: return 'Edita';
					case 14: return 'Radovan';
					case 15: return 'Alice';
					case 16: return 'Ctirad';
					case 17: return 'Drahoslav';
					case 18: return 'Vladislav';
					case 19: return 'Doubravka';
					case 20: return 'Ilona';
					case 21: return 'Běla';
					case 22: return 'Slavomír';
					case 23: return 'Zdeněk';
					case 24: return 'Milena';
					case 25: return 'Miloš';
					case 26: return 'Zora';
					case 27: return 'Ingrid';
					case 28: return 'Otýlie';
					case 29: return 'Zdislava';
					case 30: return 'Robin';
					case 31: return 'Marika';
				};
				break;
			case 2:
				switch ($day) {
					case 1: return 'Hynek';
					case 2: return 'Nela';
					case 3: return 'Blažej';
					case 4: return 'Jarmila';
					case 5: return 'Dobromila';
					case 6: return 'Vanda';
					case 7: return 'Veronika';
					case 8: return 'Milada';
					case 9: return 'Apolena';
					case 10: return 'Mojmír';
					case 11: return 'Božena';
					case 12: return 'Slavěna';
					case 13: return 'Věnceslav';
					case 14: return 'Valentýn';
					case 15: return 'Jiřina';
					case 16: return 'Ljuba';
					case 17: return 'Miloslava';
					case 18: return 'Gizela';
					case 19: return 'Patrik';
					case 20: return 'Oldřich';
					case 21: return 'Lenka';
					case 22: return 'Petr';
					case 23: return 'Svatopluk';
					case 24: return 'Matěj';
					case 25: return 'Liliana';
					case 26: return 'Dorota';
					case 27: return 'Alexandr';
					case 28: return 'Lumír';
					case 29: return '';
				};
				break;
			case 3:
				switch ($day) {
					case 1: return 'Bedřich';
					case 2: return 'Anežka';
					case 3: return 'Kamil';
					case 4: return 'Stela';
					case 5: return 'Kazimir';
					case 6: return 'Miroslav';
					case 7: return 'Tomáš';
					case 8: return 'Gabriela';
					case 9: return 'Františka';
					case 10: return 'Viktorie';
					case 11: return 'Anděla';
					case 12: return 'Řehoř';
					case 13: return 'Růžena';
					case 14: return 'Růt a matylda';
					case 15: return 'Ida';
					case 16: return 'Elena a herbert';
					case 17: return 'Vlastimil';
					case 18: return 'Eduard';
					case 19: return 'Josef';
					case 20: return 'Světlana';
					case 21: return 'Radek';
					case 22: return 'Leona';
					case 23: return 'Ivona';
					case 24: return 'Gabriel';
					case 25: return 'Marian';
					case 26: return 'Emanuel';
					case 27: return 'Dita';
					case 28: return 'Soňa';
					case 29: return 'Taťána';
					case 30: return 'Arnošt';
					case 31: return 'Kvido';
				};
				break;
			case 4:
				switch ($day) {
					case 1: return 'Hugo';
					case 2: return 'Erika';
					case 3: return 'Richard';
					case 4: return 'Ivana';
					case 5: return 'Miroslava';
					case 6: return 'Vendula';
					case 7: return 'Heřman a Hermína';
					case 8: return 'Ema';
					case 9: return 'Dušan';
					case 10: return 'Darja';
					case 11: return 'Izabela';
					case 12: return 'Julius';
					case 13: return 'Aleš';
					case 14: return 'Vincenc';
					case 15: return 'Anastázie';
					case 16: return 'Irena';
					case 17: return 'Rudolf';
					case 18: return 'Valérie';
					case 19: return 'Rostislav';
					case 20: return 'Marcela';
					case 21: return 'Alexandra';
					case 22: return 'Evženie';
					case 23: return 'Vojtěch';
					case 24: return 'Jiří';
					case 25: return 'Marek';
					case 26: return 'Oto';
					case 27: return 'Jaroslav';
					case 28: return 'Vlastislav';
					case 29: return 'Robert';
					case 30: return 'Blahoslav';
				};
				break;
			case 5:
				switch ($day) {
					case 1: return 'Svátek práce';
					case 2: return 'Zikmund';
					case 3: return 'Alexej';
					case 4: return 'Květoslav';
					case 5: return 'Klaudie';
					case 6: return 'Radoslav';
					case 7: return 'Stanislav';
					case 8: return 'Den osvobození ČSR - 1945';
					case 9: return 'Ctibor';
					case 10: return 'Blažena';
					case 11: return 'Svatava';
					case 12: return 'Pankrác';
					case 13: return 'Servác';
					case 14: return 'Bonifác';
					case 15: return 'Žofie';
					case 16: return 'Přemysl';
					case 17: return 'Aneta';
					case 18: return 'Nataša';
					case 19: return 'Ivo';
					case 20: return 'Zbyšek';
					case 21: return 'Monika';
					case 22: return 'Emil';
					case 23: return 'Vladimír';
					case 24: return 'Jana';
					case 25: return 'Viola';
					case 26: return 'Filip';
					case 27: return 'Valdemar';
					case 28: return 'Vilém';
					case 29: return 'Maxmilián';
					case 30: return 'Ferdinand';
					case 31: return 'Kamila';
				};
				break;
			case 6:
				switch ($day) {
					case 1: return 'Laura';
					case 2: return 'Jarmil';
					case 3: return 'Tamara';
					case 4: return 'Dalibor';
					case 5: return 'Dobroslav';
					case 6: return 'Norbert';
					case 7: return 'Iveta a Slavoj';
					case 8: return 'Medard';
					case 9: return 'Stanislava';
					case 10: return 'Gita';
					case 11: return 'Bruno';
					case 12: return 'Antonie';
					case 13: return 'Antonín';
					case 14: return 'Roland';
					case 15: return 'Vít';
					case 16: return 'Zbyněk';
					case 17: return 'Adolf';
					case 18: return 'Milan';
					case 19: return 'Leoš';
					case 20: return 'Květa';
					case 21: return 'Alois';
					case 22: return 'Pavla';
					case 23: return 'Zdeňka';
					case 24: return 'Jan';
					case 25: return 'Ivan';
					case 26: return 'Adriana';
					case 27: return 'Ladislav';
					case 28: return 'Lubomír';
					case 29: return 'Petr a Pavel';
					case 30: return 'Šárka';
				}
				break;
			case 7:
				switch ($day) {
					case 1: return 'Jaroslava';
					case 2: return 'Patricie';
					case 3: return 'Radomír';
					case 4: return 'Prokop';
					case 5: return 'Dem slovanských věrozvěstů Cyrila a Metoděje';
					case 6: return 'Upálení mistra Jana Husa - 1415';
					case 7: return 'Bohuslava';
					case 8: return 'Nora';
					case 9: return 'Drahoslava';
					case 10: return 'Libuše a Amálie';
					case 11: return 'Olga';
					case 12: return 'Bořek';
					case 13: return 'Markéta';
					case 14: return 'Karolína';
					case 15: return 'Jindřich';
					case 16: return 'Luboš';
					case 17: return 'Martina';
					case 18: return 'Drahomíra';
					case 19: return 'Čeněk';
					case 20: return 'Ilja';
					case 21: return 'Vítězslav';
					case 22: return 'Magdaléna';
					case 23: return 'Libor';
					case 24: return 'Kristýna';
					case 25: return 'Jakub';
					case 26: return 'Anna';
					case 27: return 'Věroslav';
					case 28: return 'Viktor';
					case 29: return 'Marta';
					case 30: return 'Bořivoj';
					case 31: return 'Ignác';
				};
				break;
			case 8:
				switch ($day) {
					case 1: return 'Oskar';
					case 2: return 'Gustav';
					case 3: return 'Miluše';
					case 4: return 'Dominik';
					case 5: return 'Kristian';
					case 6: return 'Oldřiška';
					case 7: return 'Lada';
					case 8: return 'Soběslav';
					case 9: return 'Roman';
					case 10: return 'Vavřinec';
					case 11: return 'Zuzana';
					case 12: return 'Klára';
					case 13: return 'Alena';
					case 14: return 'Alan';
					case 15: return 'Hana';
					case 16: return 'Jáchym';
					case 17: return 'Petra';
					case 18: return 'Helena';
					case 19: return 'Ludvík';
					case 20: return 'Bernard';
					case 21: return 'Johana';
					case 22: return 'Bohuslav';
					case 23: return 'Sandra';
					case 24: return 'Bartoloměj';
					case 25: return 'Radim';
					case 26: return 'Luděk';
					case 27: return 'Otakar';
					case 28: return 'Augustýn';
					case 29: return 'Evelína';
					case 30: return 'Vladěna';
					case 31: return 'Pavlína';
				};
				break;
			case 9:
				switch ($day) {
					case 1: return 'Linda a Samuel';
					case 2: return 'Adéla';
					case 3: return 'Bronislav';
					case 4: return 'Jindřiška';
					case 5: return 'Boris';
					case 6: return 'Boleslav';
					case 7: return 'Regína';
					case 8: return 'Mariana';
					case 9: return 'Daniela';
					case 10: return 'Irma';
					case 11: return 'Denisa';
					case 12: return 'Marie';
					case 13: return 'Lubor';
					case 14: return 'Radka';
					case 15: return 'Jolana';
					case 16: return 'Ludmila';
					case 17: return 'Naděžda';
					case 18: return 'Kryštof';
					case 19: return 'Zita';
					case 20: return 'Oleg';
					case 21: return 'Matouš';
					case 22: return 'Darina';
					case 23: return 'Berta';
					case 24: return 'Jaromír';
					case 25: return 'Zlata';
					case 26: return 'Andrea';
					case 27: return 'Jonáš';
					case 28: return 'Václav';
					case 29: return 'Michal';
					case 30: return 'Jeroným';
				};
				break;
			case 10:
				switch ($day) {
					case 1: return 'Igor';
					case 2: return 'Olivie a Oliver';
					case 3: return 'Bohumil';
					case 4: return 'František';
					case 5: return 'Eliška';
					case 6: return 'Hanuš';
					case 7: return 'Justýna';
					case 8: return 'Věra';
					case 9: return 'Štefan a Sára';
					case 10: return 'Marina';
					case 11: return 'Andrej';
					case 12: return 'Marcel';
					case 13: return 'Renáta';
					case 14: return 'Agáta';
					case 15: return 'Tereza';
					case 16: return 'Havel';
					case 17: return 'Hedvika';
					case 18: return 'Lukáš';
					case 19: return 'Michaela';
					case 20: return 'Vendelín';
					case 21: return 'Brigita';
					case 22: return 'Sabina';
					case 23: return 'Teodor';
					case 24: return 'Nina';
					case 25: return 'Beáta';
					case 26: return 'Erik';
					case 27: return 'Šarlota a Zoe';
					case 28: return 'Založení ČSR - 1918';
					case 29: return 'Silvie';
					case 30: return 'Tadeáš';
					case 31: return 'Štěpánka';
				};
				break;
			case 11:
				switch ($day) {
					case 1: return 'Felix';
					case 2: return 'Památka zesnulých';
					case 3: return 'Hubert';
					case 4: return 'Karel';
					case 5: return 'Miriam';
					case 6: return 'Liběna';
					case 7: return 'Saskie';
					case 8: return 'Bohumír';
					case 9: return 'Bohdan';
					case 10: return 'Evžen';
					case 11: return 'Martin';
					case 12: return 'Benedikt';
					case 13: return 'Tibor';
					case 14: return 'Sáva';
					case 15: return 'Leopold';
					case 16: return 'Otmar';
					case 17: return 'Mahulena';
					case 18: return 'Romana';
					case 19: return 'Alžběta';
					case 20: return 'Nikola';
					case 21: return 'Albert';
					case 22: return 'Cecílie';
					case 23: return 'Klement';
					case 24: return 'Emílie';
					case 25: return 'Kateřina';
					case 26: return 'Artur';
					case 27: return 'Xenie';
					case 28: return 'René';
					case 29: return 'Zina';
					case 30: return 'Ondřej';
					case 31: return 'Iva';
				};
				break;
			case 12:
				switch ($day) {
					case 1: return 'Iva';
					case 2: return 'Blanka';
					case 3: return 'Svatoslav';
					case 4: return 'Barbora';
					case 5: return 'Jitka';
					case 6: return 'Mikuláš';
					case 7: return 'Ambrož a Benjamín';
					case 8: return 'Květoslava';
					case 9: return 'Vratislav';
					case 10: return 'Julie';
					case 11: return 'Dana';
					case 12: return 'Simona';
					case 13: return 'Lucie';
					case 14: return 'Lýdie';
					case 15: return 'Radana a Radan';
					case 16: return 'Albína';
					case 17: return 'Daniel';
					case 18: return 'Miloslav';
					case 19: return 'Ester';
					case 20: return 'Dagmar';
					case 21: return 'Natálie';
					case 22: return 'Šimon';
					case 23: return 'Vlasta';
					case 24: return 'Adam a Eva';
					case 25: return 'Boží hod vánoční';
					case 26: return 'Štěpán';
					case 27: return 'Žaneta';
					case 28: return 'Bohumila';
					case 29: return 'Judita';
					case 30: return 'David';
					case 31: return 'Silvestr';
				};
				break;
		}
		throw new DataType\InvalidArgumentsException('Bad month or day.');
	}

}
