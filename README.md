## Data type

[![Downloads this Month](https://img.shields.io/packagist/dm/h4kuna/data-type.svg)](https://packagist.org/packages/h4kuna/data-type)
[![Latest Stable Version](https://poser.pugx.org/h4kuna/data-type/v/stable?format=flat)](https://packagist.org/packages/h4kuna/data-type)
[![Coverage Status](https://coveralls.io/repos/github/h4kuna/data-type/badge.svg?branch=main)](https://coveralls.io/github/h4kuna/data-type?branch=main)
[![Total Downloads](https://poser.pugx.org/h4kuna/data-type/downloads?format=flat)](https://packagist.org/packages/h4kuna/data-type)
[![License](https://poser.pugx.org/h4kuna/data-type/license?format=flat)](https://packagist.org/packages/h4kuna/data-type)

Part of the [h4kuna PHP libraries](https://github.com/h4kuna/library), see the overview of all packages.

Installation by composer
-----------------------
```sh
$ composer require h4kuna/data-type
```

Requires PHP 8.2.

- [Basic](src/Basic) - Arrays, BitwiseOperations, Bools, Floats, Integer, Lists, Set, Strings
- [Collection](src/Collection) - Counter, LazyBuilder, StrictTypeArray, JsonToHtml
- [Date](src/Date) - czech Calendar, Easter, Parser, Time, Convert, Interval, Sleep
- [Iterators](src/Iterators) - TextIterator, CsvIterator, FlattenArrayRecursiveIterator, PeriodDayFactory, ActiveWait, ReverseIterator
- [Location](src/Location) - Gps
- [Number](src/Number) - Math, RomeNumber

## Exceptions

All runtime exceptions extend `h4kuna\DataType\Exceptions\DataTypeException` (a `RuntimeException`):

- `InvalidTypeException` - a value cannot be converted to the requested type
- `InvalidArgumentsException` - input data cannot be processed (date format, GPS format, ...)
- `ActiveWaitTimeoutException` - `ActiveWait` timeout expired

Wrong usage of the library throws `h4kuna\DataType\Exceptions\LogicException`, do not catch it, fix the code.
