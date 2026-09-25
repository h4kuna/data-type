# Basic

All classes are static. Every conversion that fails throws `h4kuna\DataType\Exceptions\InvalidTypeException`.

- [Arrays](#arrays)
- [BitwiseOperations](#bitwiseoperations)
- [Bools](#bools)
- [Floats](#floats)
- [Integer](#integer)
- [Lists](#lists)
- [Set](#set)
- [Strings](#strings)

# Arrays

```php
use h4kuna\DataType\Basic\Arrays;
```

## Arrays::combine

Extension of [array_combine](//php.net/manual/en/function.array-combine.php), values do not need the same size as keys. Missing values are filled by the third parameter (`null` by default). More values than keys throw `LogicException`.

```php
Arrays::combine([1, 2, 3, 4], ['one', 'two', 'three', 'four']);
// [1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four']

Arrays::combine([1, 2, 3, 4], ['one', 'three', 'four']);
// [1 => 'one', 2 => 'three', 3 => 'four', 4 => null]

Arrays::combine([1, 2, 3, 4], ['one', 'three', 'four'], 'five');
// [1 => 'one', 2 => 'three', 3 => 'four', 4 => 'five']
```

## Arrays::contains

Strict `in_array`.

```php
Arrays::contains('1', [1, '1']); // true
Arrays::contains('1', [1]); // false
```

## Arrays::filter

Remove `false`, `''` and `null`, keys are preserved. Zero and `'0'` are kept.

```php
$array = [1 => 0, 2 => null, 3 => 'three', 4 => false, 5 => 'five', 6 => '', 7 => '0'];

Arrays::filter($array);
// [1 => 0, 3 => 'three', 5 => 'five', 7 => '0']
```

## Arrays::join

Implode only values that pass `Arrays::filter`, so the delimiter is never doubled.

```php
$array = [1 => 0, 2 => null, 3 => 'three', 4 => false, 5 => 'five', 6 => '', 7 => '0'];

implode('|', $array);
// 0||three||five||0

Arrays::join($array, '|');
// 0|three|five|0
```

`Arrays::concatWs(string $glue, array $array)` is a deprecated alias with swapped parameters.

## Arrays::explode

Native `explode(',', '')` returns `['']`, this returns `[]`. The delimiter must not be empty.

```php
Arrays::explode(''); // []
Arrays::explode('a,b,c'); // ['a', 'b', 'c']
Arrays::explode('a,b,c', ',', 2); // ['a', 'b,c']
```

## Arrays::coalesce

First non-null value, like `COALESCE` in a database.

```php
Arrays::coalesce([null, false]); // false
Arrays::coalesce([null, null]); // null
```

## Arrays::intersectKeys

Keep only the given keys.

```php
$array = [1 => 0, 2 => null, 3 => 'three', 4 => false, 5 => 'five', 6 => '', 7 => '0'];

Arrays::intersectKeys($array, [2, 3, 5]);
// [2 => null, 3 => 'three', 5 => 'five']
```

## Arrays::unsetKeys

Unset keys from the array (passed by reference) and return the removed items.

```php
$array = [1 => 0, 2 => null, 3 => 'three', 4 => false, 5 => 'five'];

Arrays::unsetKeys($array, 1, 2);
// [1 => 0, 2 => null]
// $array is [3 => 'three', 4 => false, 5 => 'five']
```

## Arrays::generateNumbers

Number line where key equals value, in both directions.

```php
Arrays::generateNumbers(2000, 2005);
// [2000 => 2000, 2001 => 2001, 2002 => 2002, 2003 => 2003, 2004 => 2004, 2005 => 2005]

Arrays::generateNumbers(2005, 2000);
// [2005 => 2005, 2004 => 2004, 2003 => 2003, 2002 => 2002, 2001 => 2001, 2000 => 2000]
```

## Arrays::mergeUnique

Merge arrays, remove duplicates and reindex.

```php
Arrays::mergeUnique(['a', 'b', 'c'], ['c', 'd', 'e'], ['b', 'd', 'f']);
// ['a', 'b', 'c', 'd', 'e', 'f']
```

## Arrays::text2Array

Split text by lines, any newline style.

```php
Arrays::text2Array("a\r\nb\nc"); // ['a', 'b', 'c']
```

`Arrays::startWith` is deprecated, use [Strings::startWith](#stringsstartwith).

# BitwiseOperations

```php
use h4kuna\DataType\Basic\BitwiseOperations;

BitwiseOperations::check(3, 2); // true, at least one bit of the flag is set
BitwiseOperations::checkStrict(3, 2); // false, number must equal the flag

$x = 2;
BitwiseOperations::add($x, 4);
echo $x; // 6

BitwiseOperations::remove($x, 4);
echo $x; // 2
```

# Bools

`true`, `false`, `null`, `''` and numeric `1` / `0` (int, float or string) are accepted, anything else throws.

```php
use h4kuna\DataType\Basic\Bools;

Bools::from(true); // true
Bools::from('1'); // true
Bools::from(1.0); // true
Bools::from('0'); // false
Bools::from(''); // false
Bools::from(null); // false
Bools::from('yes'); // throws InvalidTypeException
Bools::from(2); // throws InvalidTypeException

Bools::nullable(null); // null
Bools::nullable('1'); // true
```

# Floats

Accept numeric values and strings with a decimal comma and a space as thousands separator. Both separators are configurable. A `H:M[:S]` string is converted via `Floats::fromHour`.

```php
use h4kuna\DataType\Basic\Floats;

Floats::from(' - 1 , 0 '); // -1.0
Floats::from('1 000,5'); // 1000.5
Floats::from('1,000.5', '.', ','); // 1000.5
Floats::from('1:30'); // 1.5
Floats::from(''); // 0.0
Floats::from('foo'); // throws InvalidTypeException

Floats::fromHour('1:30'); // 1.5
Floats::fromHour('1:30:30'); // 1.508333...

Floats::nullable(null); // null
Floats::nullable(''); // 0.0
```

# Integer

Accept int, bool, `null`, `''` and numeric values without a fraction. Whitespace and thousands separators are not accepted.

```php
use h4kuna\DataType\Basic\Integer;

Integer::from('-1000'); // -1000
Integer::from('1.0'); // 1
Integer::from(''); // 0
Integer::from(true); // 1
Integer::from('1.5'); // throws InvalidTypeException
Integer::from('1 000'); // throws InvalidTypeException

Integer::nullable(null); // null
Integer::nullable('1'); // 1
```

# Lists

Methods return a `list`.

```php
use h4kuna\DataType\Basic\Lists;

Lists::stringKeys([1 => 'a', 'b' => 2]); // ['1', 'b']
```

# Set

Transform MySQL data type SET (comma separated string) to a checkbox-like array and back. Only keys with a truthy value are kept.

```php
use h4kuna\DataType\Basic\Set;

Set::fromString('one,two');
// ['one' => true, 'two' => true]

Set::toString(['one' => true, 'two' => true]);
// one,two

Set::toString(['one' => true, 'two' => false, 'three' => true]);
// one,three
```

# Strings

```php
use h4kuna\DataType\Basic\Strings;
```

## Case conversion

```php
Strings::toPascal('user_id'); // UserId
Strings::toCamel('user_id'); // userId
Strings::toUnderscore('userId'); // user_id
Strings::toUnderscore('UserId'); // user_id
```

## Strings::from / Strings::nullable

Scalar or `null` to string, anything else throws `InvalidTypeException`.

```php
Strings::from(1.5); // '1.5'
Strings::from(null); // ''
Strings::from([]); // throws InvalidTypeException

Strings::nullable(null); // null
Strings::nullable(1); // '1'
```

## Shortcuts to other classes

```php
Strings::toInt('1'); // 1, see Integer::from
Strings::toFloat('1,5'); // 1.5, see Floats::from
Strings::toSet('a,b'); // ['a' => true, 'b' => true], see Set::fromString
Strings::toGps('50.0835494N, 14.4341414E'); // see Location\Gps::fromString
```

## Strings::startWith

True when the haystack starts with any of the needles.

```php
Strings::startWith('+1', '+', '-'); // true
Strings::startWith('-1', '+', '-'); // true
Strings::startWith('1', '+', '-'); // false
```

## Strings::strokeToPoint

Replace a decimal comma with a point.

```php
Strings::strokeToPoint('1,5'); // '1.5'
```

## Strings::key

Build a cache key from values, joined by `\0`.

```php
Strings::key('a', 1, 'b'); // "a\01\0b"
```

## Strings::padIfNeed

Add the pad string only when it is missing.

```php
Strings::padIfNeed('foo', '#'); // #foo, STR_PAD_LEFT is default
Strings::padIfNeed('foo', '#', STR_PAD_BOTH); // #foo#
Strings::padIfNeed('#foo', '#', STR_PAD_BOTH); // #foo#
Strings::padIfNeed('foo#', '#', STR_PAD_BOTH); // #foo#
Strings::padIfNeed('#foo#', '#', STR_PAD_BOTH); // #foo#
```

## Strings::replaceStart / Strings::replaceEnd

Strictly replace at the start or at the end, one match, case-sensitive.

```php
// matched
Strings::replaceStart('FooBar', 'Foo', '#'); // #Bar
Strings::replaceEnd('FooBar', 'Bar', '#'); // Foo#

// not matched
Strings::replaceStart('BarFoo', 'Foo', '#'); // BarFoo
Strings::replaceEnd('BarFoo', 'Bar', '#'); // BarFoo
```

`Strings::split` and `Strings::join` are deprecated, use [Arrays::explode](#arraysexplode) and [Arrays::join](#arraysjoin).
