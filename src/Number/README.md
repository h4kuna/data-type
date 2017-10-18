Number
========

# Math

## Interval
```php
Math::interval(number, max, min = 0);
Math::interva(10, 20, 5); // 10
Math::interva(10, 9, 5); // 9
Math::interva(10, 15, 11); // 11
```

## Roud 5
```php
Math::round5(1.24) // 1.0
Math::round5(1.25) // 1.5
Math::round5(1.74) // 1.5
Math::round5(1.75) // 2.0
```

## Safe division
```php
Math::safeDivision(5, 0); // NULL
Math::safeDivision(0, 5); // 0.0
```

## Factorial
```php
Math::factorial(5); // 120
```

# Rome number
```php
RomeNumber::getRome(1968); // MCMLXVIII
RomeNumber::getArabic('MCMLXVIII'); // 1968
```
