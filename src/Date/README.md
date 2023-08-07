# Calendar

This class is for czech country.

Calendar::getDays
-----------------
List of czech days. 1 => 'Pondělí' ...

Calendar::getMonths
-------------------
List of czech month. 1 => 'Leden' ...

Calendar::nameOfDay
-------------------
Accept int or object DateTime and return name of day.

```php
Calendar::nameOfDay(1);
// Pondělí

Calendar::nameOfDay(new DateTime('1986-12-30'));
// Úterý
```

Calendar::nameOfMonth
---------------------

```php
Calendar::nameOfMonth(1);
// Leden

Calendar::nameOfMonth(new DateTime('1986-12-30'));
// Prosinec
```

Calendar::czech2DateTime
------------------------
Czech date time format convert to DateTime object.

```php
Calendar::czech2DateTime('01.01.2000');
Calendar::czech2DateTime('1.1.2000');
// return object DateTime('2000-01-01')

Calendar::czech2DateTime('01.01.2000 01:01:01');
Calendar::czech2DateTime('01.01.2000 1:1:1');
// return object DateTime('2000-01-01 01:01:01')

Calendar::czech2DateTime('01.01.2000 01:01');
// return object DateTime('2000-01-01 01:01:00')
```

Calendar::februaryOfDay
-----------------------
How many days have Fabruary in year.

```php
Calendar::februaryOfDay(2012);
// 29

Calendar::februaryOfDay(2013);
// 28
```

Calendar::easter
----------------
Return Easter Monday as DateTime object.

```php
Calendar::easter(); // is actualy year

Calendar::easter('2012');
// 2012-04-09
```

Calendar::getName
-----------------
Return whose name's day.

```php
Calendar::getName(new DateTime('2013-12-24')));
// Adam a Eva
```

DatePeriod
==========
Class has method **create($from, $to, $interval = null, $options = 4)**, witch it receives parameters like string.

```php
$period = DatePeriod::create('2017-10-10', '2017-10-12');
foreach ($period as $date) {
    // 2017-10-10
    // 2017-10-11
    // 2017-10-12
}
``` 

DateTimeString
==============
Class guaranteed date is valid if return \Datetime object. For example if you send **2018-02-29** than standard `\DateTime::createFromFormat();` return **2018-03-01 HH:MM:SS.UUUUUU**.

```php
DateTimeString::from('d.m.Y', '29.2.2018'); // null
DateTimeString::from('d.m.Y', '28.2.2018'); // object \Datetime
```

You can set own Datetime class.

```php
class MyDatetime extends \DateTime
{

	public function __toString()
	{
		return $this->format('Y-m-d H:i:s');
	}
}

DateTimeString::setClass(MyDatetime::class);
```

# DateTime

Try to create object DateTime from string fragment.

```php
use h4kuna\DataType\Date\DateTime;

DateTime::fromString('1'); // today 01:00:00
DateTime::fromString('1:20'); // today 01:20:00
DateTime::fromString('1:20:30'); // today 01:20:30
DateTime::fromString('+1'); // now +1 hour
DateTime::fromString('-1'); // now -1 hour
DateTime::fromString('-1.5'); // now -1 hour and -30 minutes 
DateTime::fromString('-1:30'); // now -1 hour and -30 minutes
DateTime::fromString('6-13 12:20'); // this year, 6. month, 13. day, time 12:20:00
```

# Sleep

Sleep in milliseconds 

```php
use h4kuna\DataType\Date\Sleep;

Sleep::seconds(0.5); // sleep 0.5s
Sleep::milliseconds(500); // sleep 0.5s
```
