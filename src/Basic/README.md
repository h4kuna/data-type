Arrays
======
Arrays::combine
---------------
Is extension for [array_combine](http://php.net/manual/en/function.array-combine.php).
```php
Arrays::combine(array(1, 2, 3, 4), array('one', 'two', 'three', 'four'));
// array(1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four')

Arrays::combine(array(1, 2, 3, 4), array('one', 'three', 'four'));
// array(1 => 'one', 2 => 'three', 3 => 'four', 4 => NULL)

Arrays::combine(array(1, 2, 3, 4), array('one', 'three', 'four'), 'five');
// array(1 => 'one', 2 => 'three', 3 => 'four', 4 => 'five')
```

Arrays::concatWs
----------------
Implode vaule and never separator will be side by side.
```php
$array = array(1 => 0, 2 => NULL, 3 => 'three', 4 => FALSE, 5 => 'five', 6 => '', 7 => '0');

implode('|', $array);
// 0||three||five||0

Arrays::concatWs('|', $array);
// 0|three|five|0

Arrays::concatWs('|', $array, 2, 4, 5, 6);
// five
```

Arrays::coalesce
----------------
Select first non-empty value.
```php
Arrays::coalesce(array(NULL, FALSE, '', 'foo');
// foo

Arrays::coalesce(array('bar', NULL, 'foo'), 1, 2);
// foo

Arrays::coalesce(array(FALSE, NULL, '');
// NULL
```

Arrays::intesectKeys
--------------------
By array of key make intersect another array.
```php
$array = array(1 => 0, 2 => NULL, 3 => 'three', 4 => FALSE, 5 => 'five', 6 => '', 7 => '0');

Arrays::intesectKeys($array, array(2, 3, 5));
// array(2 => NULL, 3 => 'three', 5 => 'five')
```

Arrays::keysUnset
-----------------
Unset keys from array and return array removed values.
```php
$array = array(1 => 0, 2 => NULL, 3 => 'three', 4 => FALSE, 5 => 'five');
Arrays::keysUnset($array, 1, 2);
// return array(1 => 0, 2 => NULL)
// and $array
// array(3 => 'three', 4 => FALSE, 5 => 'five')
```

Arrays::column
--------------
Is wrapper for [array_column](http://php.net/manual/en/function.array-column.php) useable for php < 5.5.
