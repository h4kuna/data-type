# TextIterator

Read the text line by line.

```php
use h4kuna\DataType\Iterators\TextIterator;
$incomingString = "  foo

bar
joe";

$textIterator = new TextIterator($incomingString);
$textIterator->setFlags($textIterator::SKIP_EMPTY_LINE | $textIterator::TRIM_LINE);
foreach($textIterator as $line) {
    echo $line;
}
/*
 * output will be trimed
foo
bar
joe
*/
```

# FlattenArrayIterator

Make one level array from multidimensional with to use delimiter for join keys.

```php
use h4kuna\DataType\Iterators\FlattenArrayRecursiveIterator;

$input = [
    'address' => [
        'street' => 'foo',
        'zip' => 29404,
        'c' => [
            'p' => '5',
            'e' => 10.6,
        ],
    ],
    'main' => ['a', 'b', 'c'],
    'email' => 'exampl@foo.com',
];

$iterator = new FlattenArrayRecursiveIterator($input, '%');
$output = [];
foreach ($iterator as $key => $item) {
    $output[$key] = $item;
}

// output is
// [
//    'address%street' => 'foo',
//    'address%zip' => 29404,
//    'address%c%p' => '5',
//    'address%c%e' => 10.6,
//    'main%0' => 'a',
//    'main%1' => 'b',
//    'main%2' => 'c',
//    'email' => 'exampl@foo.com',
// ]
```

# PeriodDayFactory

Iterate between dates by days. A time is reset to midnight.

```php
use h4kuna\DataType\Iterators\PeriodDayFactory;
$endDate = new \DateTime('1996-04-09 08:00:00');
$period = PeriodDayFactory::createExFromInTo(new \DateTime('1989-02-01 07:00:00'), $endDate);

foreach ($period as $date) {
    // first date is 1989-02-02
    // last date is 1996-04-09
}

```

# ActiveWait

Use callback for resolve condition and wait for `true`.

```php
use h4kuna\DataType\Iterators\ActiveWait;

$wait = new ActiveWait(0.3); // wait 0.3s = 300ms

$wait->run(fn(): bool => random_int(1, 5) === 4);
```
