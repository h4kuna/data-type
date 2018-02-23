# Immutable

Object does not change internal state.

## Messenger
Data are locked in object you can not change it.

```php
$values = new Messenger(['foo' => 'bar']);
echo $values->foo; // bar
echo $values['foo']; // bar

isset($values->foo) // true
isset($values->doe) // false

echo count($values); // 1

json_encode($values); // use only property data
serialize($values); // use only property data

$values->getData() // return internal array

$clone1 = $values->foo = 'doe'; // create clone
$clone2 = $values->remove('foo' /* , more, keys */); // create clone
unset($values->foo); // throw exception

foreach ($values as $key => $value) {
    ...
}
```

If you use for own data structure, extend this class and write annotations, your IDE will suggest you.

```php
/**
 * @property-read string $foo
 */
class MyMessenger extends Messenger 
{
}
```