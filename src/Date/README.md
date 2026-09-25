# Date

- [Calendar](#calendar) (Czech names)
- [Easter](#easter)
- [Parser](#parser)
- [Time](#time)
- [Convert](#convert)
- [Interval](#interval)
- [Sleep](#sleep)

# Calendar

Czech names of days, months and name days. Invalid input throws `InvalidArgumentsException`.

```php
use h4kuna\DataType\Date\Calendar;
```

## Calendar::getDays / Calendar::getMonths

```php
Calendar::getDays(); // [1 => 'Pondělí', 2 => 'Úterý', ... 7 => 'Neděle']
Calendar::getMonths(); // [1 => 'Leden', 2 => 'Únor', ... 12 => 'Prosinec']
```

## Calendar::nameOfDay

Accept a number 0-7 (0 and 7 are Sunday), a numeric string, `DateTimeInterface` or `null` for today.

```php
Calendar::nameOfDay(1); // Pondělí
Calendar::nameOfDay('5'); // Pátek
Calendar::nameOfDay(0); // Neděle
Calendar::nameOfDay(new DateTime('1986-12-30')); // Úterý
Calendar::nameOfDay(); // today
Calendar::nameOfDay(8); // throws InvalidArgumentsException
```

## Calendar::nameOfMonth

Accept a number 1-12, a numeric string, `DateTimeInterface` or `null` for the current month.

```php
Calendar::nameOfMonth(1); // Leden
Calendar::nameOfMonth(new DateTime('1986-12-30')); // Prosinec
Calendar::nameOfMonth(); // current month
Calendar::nameOfMonth(13); // throws InvalidArgumentsException
```

## Calendar::czech2DateTime

Czech format `DD.MM.YYYY[ HH:MM[:SS]]` to `DateTimeImmutable`.

```php
Calendar::czech2DateTime('01.01.2000');
Calendar::czech2DateTime('1.1.2000');
// DateTimeImmutable 2000-01-01 00:00:00

Calendar::czech2DateTime('01.01.2000 01:01:01');
Calendar::czech2DateTime('01.01.2000 1:1:1');
// DateTimeImmutable 2000-01-01 01:01:01

Calendar::czech2DateTime('01.01.2000 01:01');
// DateTimeImmutable 2000-01-01 01:01:00

Calendar::czech2DateTime('2000-01-01'); // throws InvalidArgumentsException
```

## Calendar::februaryOfDay

How many days February has in the year, accepts int or `DateTimeInterface`.

```php
Calendar::februaryOfDay(2012); // 29
Calendar::februaryOfDay(2013); // 28
```

## Calendar::nameByDate

Czech name day for the date, today by default.

```php
Calendar::nameByDate(new DateTime('2013-12-24')); // Adam a Eva
Calendar::nameByDate(); // today
Calendar::names(); // all name days as [month => [day => name]]
```

The source file with names is `Calendar::$namesFile`, it is loaded once.

`Calendar::easter()` is deprecated, use `Easter::monday()`.

# Easter

Easter dates as `DateTimeImmutable` at midnight, the current year by default. The native `easter_date()` is used when the `calendar` extension is loaded, otherwise the date is computed, both give the same result for years 1970-2037.

```php
use h4kuna\DataType\Date\Easter;

Easter::friday(2012); // 2012-04-06
Easter::sunday(2012); // 2012-04-08
Easter::monday(2012); // 2012-04-09
Easter::monday(); // current year
```

# Parser

Create `DateTime` or `DateTimeImmutable` from a short string. The second parameter is the base date and decides the returned class, `DateTimeImmutable` with the current time by default. Unknown format throws `InvalidArgumentsException`.

```php
use h4kuna\DataType\Date\Parser;

Parser::fromString('1'); // today 01:00:00
Parser::fromString('1:20'); // today 01:20:00
Parser::fromString('1:20:30'); // today 01:20:30
Parser::fromString('+1'); // now +1 hour
Parser::fromString('-1'); // now -1 hour
Parser::fromString('-1.5'); // now -1 hour and -30 minutes
Parser::fromString('-1:30'); // now -1 hour and -30 minutes
Parser::fromString('6-13 12:20'); // this year, 13th June, 12:20:00
Parser::fromString('2023-06-11 08:30'); // 2023-06-11 08:30:00
Parser::fromString(''); // now

Parser::fromString('1:20', new DateTime('2023-06-11 07:00:00')); // DateTime 2023-06-11 01:20:00
```

# Time

```php
use h4kuna\DataType\Date\Time;

Time::micro(); // microtime(true)

// seconds since midnight, accept "HH:MM[:SS]" or DateTimeInterface
Time::only('1:30'); // 5400
Time::only(new DateTime('2023-06-11 01:30:00')); // 5400

// set time, null keeps the original part, returns the same class as given
Time::time(new DateTimeImmutable('2023-06-11 07:00:00'), 12, 30); // 2023-06-11 12:30:00
Time::time($dateTime, microseconds: 0); // only drop microseconds

// set date, null keeps the original part
Time::date(new DateTimeImmutable('2023-06-11 07:00:00'), 2000, 1); // 2000-01-11 07:00:00
```

# Convert

Conversions between `DateTime` and `DateTimeImmutable`.

```php
use h4kuna\DataType\Date\Convert;

Convert::timestampToImmutable(946684800); // DateTimeImmutable
Convert::toImmutable(new DateTime()); // DateTimeImmutable, immutable input is returned as is
Convert::toMutable(new DateTimeImmutable()); // DateTime, mutable input is cloned
Convert::toImmutableMidnight(new DateTime('2023-06-11 07:00:00')); // DateTimeImmutable 2023-06-11 00:00:00

// convert $dateTime to the class of $source
Convert::bySource(new DateTime(), new DateTimeImmutable()); // DateTime
```

# Interval

```php
use h4kuna\DataType\Date\Interval;

Interval::toSeconds(new DateInterval('PT1H30M')); // 5400
Interval::toSecondsMilli(new DateInterval('PT1H30M')); // 5400.0, with microseconds
Interval::toSeconds((new DateTime('2023-06-01'))->diff(new DateTime('2022-06-01'))); // negative for inverted interval

// clamp the date between from and to, see Number\Math::interval
Interval::interval(new DateTime('2023-01-10'), new DateTime('2023-01-01'), new DateTime('2023-01-05')); // 2023-01-05
```

# Sleep

```php
use h4kuna\DataType\Date\Sleep;

Sleep::seconds(0.5); // sleep 0.5s
Sleep::milliseconds(500); // sleep 0.5s
Sleep::milliseconds(0.5); // sleep 500µs
```
