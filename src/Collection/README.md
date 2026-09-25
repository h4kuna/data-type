# Collection

- [Counter](#counter)
- [LazyBuilder](#lazybuilder)
- [StrictTypeArray](#stricttypearray)
- [JsonToHtml](#jsontohtml)

# Counter

Count events with an optional limit. The constructor parameter decides the limit:

- positive number: seconds, older ticks are garbage
- `0` (`Counter::DISABLE_GARBAGE`, default): count forever
- negative number: maximum count of ticks in the stack, older ticks are garbage and `isFull()` is true once the count is exceeded

```php
use h4kuna\DataType\Collection\Counter;

$counter = new Counter(2); // ticks older than 2 seconds are garbage

$counter->tick();
$counter->tick();
$counter->tick('joe'); // any message can be stored

$counter->isFull(); // false
$counter->count(); // 3
$counter->last(); // ['message' => 'joe', 'time' => <float>]

sleep(3);
$counter->isFull(); // true, the oldest tick is older than 2 seconds
$counter->count(); // 0, garbage is called internally
$counter->last(); // null

$counter->reset(); // drop everything
```

Retry with a limit of failures:

```php
use h4kuna\DataType\Collection\Counter;

$counter = new Counter(-3); // full after more than 3 ticks, the 4th failure is thrown

while (true) {
    try {
        doAnything();
        break;
    } catch (\Throwable $e) {
        $counter->tick($e);
        if ($counter->isFull()) {
            throw $e;
        }
    }
}
```

# LazyBuilder

Keep objects by name. Add either the object itself or a `Closure` that creates it on the first `get()`. The closure receives the builder as the first parameter.

```php
use h4kuna\DataType\Collection\LazyBuilder;

/**
 * @extends LazyBuilder<DateTimeZone>
 */
class MyLazyBuilder extends LazyBuilder
{
}

$builder = new MyLazyBuilder([
    'czech' => new DateTimeZone('Europe/Prague'),
    'germany' => fn () => new DateTimeZone('Europe/Berlin'), // created lazily
]);
$builder->setDefault(fn (string|int $key) => new DateTimeZone('UTC')); // used for unknown keys

$builder->add('france', new DateTimeZone('Europe/Paris'));
$builder->add('poland', fn () => new DateTimeZone('Europe/Warsaw'));

$builder->has('germany'); // true, the closure exists
$builder->get('germany'); // DateTimeZone Europe/Berlin

$builder->has('italy'); // false
$builder->get('italy'); // DateTimeZone UTC from default
$builder->getDefault(); // the default closure
```

Without a default, `get()` with an unknown key throws `LogicException`. The default can be set only once, otherwise `LogicException` is thrown.

# StrictTypeArray

Read `array<mixed>` with strict types, useful for decoded JSON or request data. Conversion uses `Basic\Strings`, `Basic\Integer`, `Basic\Floats` and `Basic\Bools`, so a value that cannot be converted throws `InvalidTypeException`. A missing key throws too, except `bool()` which returns `false`. The `*Null` variants return `null` for a missing or `null` value.

```php
use h4kuna\DataType\Collection\StrictTypeArray;

$strictTypeArray = new StrictTypeArray([
    'a' => null,
    'b' => '1',
    'c' => 'lorem',
    'e' => ['x'],
]);

$strictTypeArray->bool('a'); // false, missing or null key is false
$strictTypeArray->bool('b'); // true
$strictTypeArray->bool('c'); // throws InvalidTypeException

$strictTypeArray->string('a'); // ''
$strictTypeArray->string('b'); // '1'
$strictTypeArray->string('c'); // 'lorem'
$strictTypeArray->string('d'); // throws InvalidTypeException, key is missing
$strictTypeArray->stringNull('d'); // null

$strictTypeArray->int('b'); // 1
$strictTypeArray->intNull('a'); // null

$strictTypeArray->float('b'); // 1.0
$strictTypeArray->floatNull('a'); // null

$strictTypeArray->array('e'); // ['x']
$strictTypeArray->array('c'); // throws InvalidTypeException
$strictTypeArray->arrayNull('d'); // null
```

# JsonToHtml

Abstract class that renders its public properties as JSON inside a `<script>` element, so a server-side configuration can be read by JavaScript. Extend it and define the properties.

```php
use h4kuna\DataType\Collection\JsonToHtml;

class MyJsonConfig extends JsonToHtml
{
    public int $foo = 1;

    public function __construct()
    {
        parent::__construct('my-config'); // id of the element
    }
}

$myJsonConfig = new MyJsonConfig();
$myJsonConfig->foo = 10;

(string) $myJsonConfig; // or $myJsonConfig->render()
// <script type="text/json" id="my-config">{"foo":10}</script>
```

Typescript

```typescript
export function loadConfig<T>(id: string): T {
    const c = document.getElementById(id)

    if (c === null) {
        throw new Error(`Could not find element with id '${id}'`)
    }

    return JSON.parse(c.textContent || c.innerHTML) as T
}

console.log(loadConfig('my-config'));
```
