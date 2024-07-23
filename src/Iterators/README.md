# TextIterator

Read the text line by line.

```php
use h4kuna\DataType\Iterators\TextIterator;
$incomingString = "  foo

bar
joe";

$textIterator = new TextIterator($incomingString);
foreach($textIterator as $line) {
    echo $line;
}
/*
 * output will be trimmed and skip empty lines
foo
bar
joe
*/
```

# CsvIterator

```php
use h4kuna\DataType\Iterators\TextIterator;
use h4kuna\DataType\Iterators\CsvIterator;
$incomingString = "1Lorem,ipsum,dolor sit,Windows
2Lorem,ipsum,dolor sit,Solaris

3Lorem,ipsum,dolor sit,Linux
4Lorem,ipsum,dolor sit,Mac
";

$csvIterator = new CsvIterator($incomingString);
// or
$csvIterator = new CsvIterator(new TextIterator($incomingString));

foreach($csvIterator as $line) {
    var_dump($line);
}
/*
array{1Lorem, ipsum, dolor sit, Windows}
array{2Lorem, ipsum, dolor sit, Solaris}
array{3Lorem, ipsum, dolor sit, Linux}
array{4Lorem, ipsum, dolor sit, Mac}
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

# ReverseArray

Run array from end to begin.

```php
use h4kuna\DataType\Iterators\ReverseArray;

$iterator = new ReverseArray([1, 2, 3]);

foreach ($iterator as $item) {
    echo $item;
}
// 3
// 2
// 1
```
