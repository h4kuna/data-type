# Counter

If you want to set limit for iteration in time.

```php
use h4kuna\DataType\Collection\Counter;
$counter = new Counter(2); // keep me only tick for two sends

$counter->tick();
$counter->tick();
$counter->tick('joe');

$counter->isFull(); // false
$counter->count(); // 3
$counter->last(); // ['message' => 'joe', 'time' => <float>]

sleep(3);
$counter->isFull(); // true = need to call garbage
$counter->count(); // 0, internally call garbage
```

Next example:

```php
use h4kuna\DataType\Collection\Counter;
$counter = new Counter(2);

while(1) {
    restore:
    try {
        doAnything();
        sleep(1);
    } catch (\Throwable $e) {
        $counter->tick();
        // or save anything
        $counter->tick($e);
        if ($counter->isFull()) {
            throw $e;
        }
        
        goto restore;
    }
}
```

# LazyBuilder

Keep objects by name. You can add objects of same type for use or add callbacks which return the defined type.

For example DatetimeZone.

```php
use h4kuna\DataType\Collection\LazyBuilder;

/**
 * @extends LazyBuilder<DateTimeZone>
 */
class MyLazyBuilder extends LazyBuilder {

}

$builder = new MyLazyBuilder([
    'czech' => new DateTimeZone('Europe/Prague'),
    'germany' => fn() => new DateTimeZone('Europe/Berlin'), // add like a callback
]);
$builder->setDefault(fn() => new DateTimeZone('UTC'));

$builder->add('france', new DateTimeZone('Europe/paris'));
$builder->add('poland', fn() => new DateTimeZone('Europe/Warsaw')); // add like a callback

$builder->has('germany'); // true, callback exists
$builder->get('germany'); // instance of DateTimeZone with 'Europe/Berlin'

$builder->has('italy'); // false
$builder->get('italy'); // instance of DateTimeZone with 'UTC'

```

# StrictTypeArray

Use for array<mixed> and you need strict type.

```php
use h4kuna\DataType\Collection\StrictTypeArray;
$strictTypeArray = new StrictTypeArray([
    'a' => null,
    'b' => '1',
    'c' => 'lorem',
]);

$strictTypeArray->bool('a'); // false
$strictTypeArray->bool('b'); // true
$strictTypeArray->bool('c'); // throw exception

$strictTypeArray->string('a'); // ''
$strictTypeArray->string('b'); // '1'
$strictTypeArray->string('c'); // 'lorem'
$strictTypeArray->string('d'); // throw exception

$strictTypeArray->stringNull('d'); // null

$strictTypeArray->int('b'); // 1
$strictTypeArray->float('b'); // 1.0
```
