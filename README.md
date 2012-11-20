## Data type

### GPS

```php
$gps = new GPS();
// in array coordinate are same
$coordinate = array('50.4113628N, 14.9032000E', '50.4113628, 14.9032000', 'N 50°24.68177', E 14°54.19200\'', '50°24\'40.906"N, 14°54\'11.520"E');
foreach($coordinate as $value){
    $gps->match($value);// array('lat' => 14.903200, 'lng' => 50.411363);
}
```

If you want change key of returned array, use
```php
$gps->setUp(6, 'x', 'y');
```


### Set

This is for MySql data type SET

```php
// in constructor define all set with translate, whose show on web
$gps = new GPS(array('car' => 'Auto', 'house' => 'Dům', 'notebook' => 'Notebook', 'bike' => 'Kolo'));
$gps->setValue('car,house');
// this is for form
$gps->getValues(); // array('car' => 'Auto', 'house' => 'Dům');

$gps->getValues(TRUE); // array('car', 'house');

```