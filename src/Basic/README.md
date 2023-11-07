# Arrays

## Arrays::combine

Is extension for [array_combine](//php.net/manual/en/function.array-combine.php).

```php
use h4kuna\DataType\Basic;

Basic\Arrays::combine([1, 2, 3, 4], ['one', 'two', 'three', 'four']);
// [1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four']

Basic\Arrays::combine([1, 2, 3, 4], ['one', 'three', 'four']);
// [1 => 'one', 2 => 'three', 3 => 'four', 4 => null]

Basic\Arrays::combine([1, 2, 3, 4], ['one', 'three', 'four'], 'five');
// [1 => 'one', 2 => 'three', 3 => 'four', 4 => 'five']
```

## Arrays::concatWs

Implode value and never separator will be side by side.

```php
use h4kuna\DataType\Basic;

$array = [1 => 0, 2 => null, 3 => 'three', 4 => false, 5 => 'five', 6 => '', 7 => '0'];

implode('|', $array);
// 0||three||five||0

Basic\Arrays::concatWs('|', $array);
// 0|three|five|0

Basic\Arrays::concatWs('|', $array, 2, 4, 5, 6);
// five
```

## Arrays::coalesce

Select first non-null value.

```php
use h4kuna\DataType\Basic;

Basic\Arrays::coalesce([null, false]);
// false
```

## Arrays::intersectKeys

By array of key make intersect another array.

```php
use h4kuna\DataType\Basic;

$array = [1 => 0, 2 => null, 3 => 'three', 4 => false, 5 => 'five', 6 => '', 7 => '0'];

Basic\Arrays::intersectKeys($array, [2, 3, 5]);
// [2 => null, 3 => 'three', 5 => 'five']
```

## Arrays::unsetKeys

Unset keys from array and return array removed values.

```php
use h4kuna\DataType\Basic;

$array = [1 => 0, 2 => null, 3 => 'three', 4 => false, 5 => 'five'];
Basic\Arrays::unsetKeys($array, 1, 2);
// return [1 => 0, 2 => null]
// and $array
// [3 => 'three', 4 => false, 5 => 'five']
```

## Arrays::generateNumbers

Prepare number line.

```php
use h4kuna\DataType\Basic;
Basic\Arrays::generateNumbers(2000, 2005);
// [2000 => 2000, 2001 => 2001, 2002 => 2002, 2003 => 2003, 2004 => 2004, 2005 => 2005]

Basic\Arrays::generateNumbers(2005, 2000);
// [2005 => 2005, 2004 => 2004, 2003 => 2003, 2002 => 2002, 2001 => 2001, 2000 => 2000]
```

## Arrays::mergeUnique

Prepare number line.

```php
use h4kuna\DataType\Basic;
Basic\Arrays::mergeUnique(['a', 'b', 'c'], ['c', 'd', 'e'], ['b', 'd', 'f']);
// ['a', 'b', 'c', 'd', 'e', 'f']
```

## Arrays::startWith

```php
use h4kuna\DataType\Basic;
$number = '+1'
Basic\Arrays::startWith($number, '+', '-'); // true
$number = '-1'
Basic\Arrays::startWith($number, '+', '-'); // true
$number = '1'
Basic\Arrays::startWith($number, '+', '-'); // false
```

# Float

This accepts whitespace and comma. Non numerics value throw exception.

```php
use h4kuna\DataType\Basic;

Basic\Floats::from(' - 1 , 0 ');
// -1.0 (float)

Basic\Floats::fromHour('1:30');
// 1.5
```

# Int

This accept whitespace. Nonnumeric or float value throw exception.

```php
use h4kuna\DataType\Basic;

Basic\Integer::from('- 1 000');
// -1000
```

# Set

Value transfer from array to string whose saved in database like MySql.

```php
use h4kuna\DataType\Basic;

Basic\Set::fromString('one,two');
// ['one' => true, 'two' => true]

Basic\Set::toString(['one' => true, 'two' => true]);
// one,two

Basic\Set::toString(['one' => true, 'two' => false, 'three' => true]);
// one,three
```

# String

Interesting methods are toCamel, toUnderscore, toPascal.

```php
use h4kuna\DataType\Basic;

Basic\Strings::toPascal('user_id'); // UserId
Basic\Strings::toCamel('user_id'); // userId
Basic\Strings::toUnderscore('userId') // user_id
Basic\Strings::toUnderscore('UserId') // user_id
```

This class is only shortcut to another method.

```php
use h4kuna\DataType\Basic;

// String to int
Basic\Strings::toInt('1'); // call Int::fromString('1');
```

```php
use h4kuna\DataType\Basic;

// String to int
Basic\Strings::padIfNeed('foo', '#'); // #foo, STR_PAD_LEFT is default
Basic\Strings::padIfNeed('foo', '#', STR_PAD_BOTH); // #foo#
Basic\Strings::padIfNeed('#foo', '#', STR_PAD_BOTH); // #foo#
Basic\Strings::padIfNeed('foo#', '#', STR_PAD_BOTH); // #foo#
Basic\Strings::padIfNeed('#foo#', '#', STR_PAD_BOTH); // #foo#
```

## Strings::explode

```php
use h4kuna\DataType\Basic\Strings;

Strings::split('foo', ''); // throw exception
Strings::split(''); // return empty []
```

## Strings::join

Filter falsy value empty string, null and empty string.

```php
use h4kuna\DataType\Basic\Strings;

Strings::join('B', null, '', false, 'A'); // "B, A"
```

# Bitwise operations

```php
use h4kuna\DataType\Basic;

Basic\BitwiseOperations::check(3, 2); // true
Basic\BitwiseOperations::checkStrict(3, 2); // false

$x = 2;
Basic\BitwiseOperations::add($x, 4);
echo $x // 6

Basic\BitwiseOperations::remove($x, 4);
echo $x // 2
```
