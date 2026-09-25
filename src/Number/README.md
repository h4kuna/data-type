# Number

- [Math](#math)
- [RomeNumber](#romenumber)

# Math

```php
use h4kuna\DataType\Number\Math;
```

## Math::interval

Clamp a number between minimum and maximum. Works for `DateTimeInterface` too, `null` disables the bound. Maximum lower than minimum throws `LogicException`.

```php
Math::interval(10, 20, 5); // 10
Math::interval(10, 9, 5); // 9
Math::interval(10, 15, 11); // 11
Math::interval(10, null, 11); // 11, no maximum
Math::interval(new DateTime('2023-01-10'), new DateTime('2023-01-05'), new DateTime('2023-01-01')); // 2023-01-05
```

## Math::round5

Round to the nearest half.

```php
Math::round5(1.24); // 1.0
Math::round5(1.25); // 1.5
Math::round5(1.74); // 1.5
Math::round5(1.75); // 2.0
```

## Math::safeDivision

`null` instead of division by zero.

```php
Math::safeDivision(5, 0); // null
Math::safeDivision(0, 5); // 0.0
Math::safeDivision(5, 2); // 2.5
```

## Math::factorial

Negative number throws `LogicException`.

```php
Math::factorial(5); // 120
Math::factorial(0); // 1
```

# RomeNumber

```php
use h4kuna\DataType\Number\RomeNumber;

RomeNumber::getRome(1968); // MCMLXVIII
RomeNumber::getArabic('MCMLXVIII'); // 1968
```
