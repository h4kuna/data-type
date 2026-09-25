# Iterators

- [TextIterator](#textiterator)
- [CsvIterator](#csviterator)
- [FlattenArrayRecursiveIterator](#flattenarrayrecursiveiterator)
- [PeriodDayFactory](#perioddayfactory)
- [ActiveWait](#activewait)
- [ReverseIterator](#reverseiterator)

# TextIterator

Read text line by line. Accept a string, an array of lines or `SplFileObject`. By default every line is trimmed and empty lines are skipped, flags change it:

- `TextIterator::KeepEmptyLine` keep empty lines
- `TextIterator::SkipFirstLine` skip the first line, useful for a CSV header
- `TextIterator::SkipTrimLine` do not trim lines

```php
use h4kuna\DataType\Iterators\TextIterator;

$incomingString = "  foo

bar
joe";

$textIterator = new TextIterator($incomingString);
foreach ($textIterator as $line) {
    echo $line;
}
/*
foo
bar
joe
*/

$textIterator = new TextIterator($incomingString, TextIterator::KeepEmptyLine | TextIterator::SkipTrimLine);
// "  foo", "", "bar", "joe"
```

`SplFileObject` with the `READ_CSV` flag throws `LogicException`, use `CsvIterator` instead.

# CsvIterator

Parse CSV rows from a string, an array, `SplFileObject` or `TextIterator`. Delimiter, enclosure, escape and `TextIterator` flags are optional parameters.

```php
use h4kuna\DataType\Iterators\CsvIterator;
use h4kuna\DataType\Iterators\TextIterator;

$incomingString = "1Lorem,ipsum,dolor sit,Windows
2Lorem,ipsum,dolor sit,Solaris

3Lorem,ipsum,dolor sit,Linux
4Lorem,ipsum,dolor sit,Mac
";

$csvIterator = new CsvIterator($incomingString);
// or
$csvIterator = new CsvIterator(new TextIterator($incomingString));

foreach ($csvIterator as $line) {
    var_dump($line);
}
/*
['1Lorem', 'ipsum', 'dolor sit', 'Windows']
['2Lorem', 'ipsum', 'dolor sit', 'Solaris']
['3Lorem', 'ipsum', 'dolor sit', 'Linux']
['4Lorem', 'ipsum', 'dolor sit', 'Mac']
*/

// semicolon delimiter, skip the header
new CsvIterator("a;b\n1;2", ';', flags: TextIterator::SkipFirstLine); // [['1', '2']]
```

# FlattenArrayRecursiveIterator

Make a one level array from a multidimensional one, keys are joined by the delimiter (`-` by default).

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

Iterate between two dates by days. The time is reset to midnight and the period always yields `DateTimeImmutable`. Four factories decide whether the first and the last day are included (In) or excluded (Ex).

```php
use h4kuna\DataType\Iterators\PeriodDayFactory;

$start = new DateTime('1989-02-01 07:00:00');
$end = new DateTime('1989-02-04 08:00:00');

PeriodDayFactory::createInFromInTo($start, $end); // 1989-02-01, 02, 03, 04
PeriodDayFactory::createExFromInTo($start, $end); // 1989-02-02, 03, 04
PeriodDayFactory::createInFromExTo($start, $end); // 1989-02-01, 02, 03
PeriodDayFactory::createExFromExTo($start, $end); // 1989-02-02, 03

foreach (PeriodDayFactory::createExFromInTo($start, $end) as $date) {
    echo $date->format('Y-m-d');
}
```

# ActiveWait

Call the callback until it returns something other than `false`, sleep between attempts. The first parameter is the sleep in seconds, the second an optional timeout in seconds. When the timeout expires, `ActiveWaitTimeoutException` is thrown, `0` means wait forever.

```php
use h4kuna\DataType\Iterators\ActiveWait;

$wait = new ActiveWait(0.3); // sleep 0.3s = 300ms between attempts
$wait->run(fn (): bool => random_int(1, 5) === 4);

$wait = new ActiveWait(0.3, 5.0); // give up after 5 seconds
$wait->run(fn (): bool => random_int(1, 5) === 4); // may throw ActiveWaitTimeoutException
```

# ReverseIterator

Iterate an array from the end to the beginning.

```php
use h4kuna\DataType\Iterators\ReverseIterator;

$iterator = new ReverseIterator([1, 2, 3]);

foreach ($iterator as $item) {
    echo $item;
}
// 3
// 2
// 1
```
