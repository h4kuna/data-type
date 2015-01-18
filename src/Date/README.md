Calendar
========
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
