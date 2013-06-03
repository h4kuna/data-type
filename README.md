## Data type

### Float

```php
$float = new Float();
$float->setValue('1'); // 1.0
$float->setValue('foo- 1,5 foo'); // -1.5
//time
$float->setValue('0:30'); // 0.5
$float->setValue('0:90'); // 1.5
```

### GPS

```php
$gps = new GPS();
// in array coordinate are same
$coordinate = array('50.4113628N, 14.9032000E', '50.4113628, 14.9032000', 'N 50°24.68177\', E 14°54.19200\'', '50°24\'40.906"N, 14°54\'11.520"E');
foreach($coordinate as $value){
    $gps->match($value);// array('lat' => 14.903200, 'lng' => 50.411363);
}
```

If you want change key of returned array, use
```php
$gps->setUp(6, 'x', 'y');
```

### Int (under construction)

```php
$int = new Int();
$float->setValue('foo- 1,5 foo'); // -1
```


### Set

This is for MySql data type SET

```php
// in constructor define all set with translate, whose show on web
$set = new Set(array('car' => 'Auto', 'house' => 'Dům', 'notebook' => 'Notebook', 'bike' => 'Kolo'));
$set->setValue('car,house');
// this is for checkbox list
$set->getSet(); // array defined in constructor

// this is for fill form
$set->getValues(); // array('car' => 'Auto', 'house' => 'Dům');

$set->getValues($set::KEYS); // array('car', 'house');

$set->getValue(); // 'car,house'
// same is
echo $set;

```