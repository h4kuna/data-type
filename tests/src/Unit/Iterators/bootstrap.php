<?php declare(strict_types=1);

use h4kuna\DataType\Iterators\CsvIterator;
use h4kuna\DataType\Iterators\TextIterator;
use Tester\Assert;

require_once __DIR__ . '/../../../bootstrap.php';

function filepath(string $name = 'original'): string
{
	return __DIR__ . "/../../../Fixtures/$name.csv";
}


/**
 * @param TextIterator<string>|CsvIterator<array<string>> $textIterator
 */
function toString(TextIterator|CsvIterator $textIterator): string
{
	$content = '';
	foreach ($textIterator as $line) {
		$content .= is_array($line) ? serialize($line) : $line;
		$content .= "\n";
	}

	return $content;
}


/**
 * @return TextIterator<string>
 */
function createTextIterator(int $flags): TextIterator
{
	$file = filepath();
	$text = file_get_contents($file);
	assert($text !== false);

	return new TextIterator($text, $flags);
}


function assertContent(string $filename, string $expected): void
{
	$file = filepath($filename);
	if (is_file($file) === false) {
		file_put_contents($file, $expected);
	}

	$source = file_get_contents($file);
	assert($source !== false);

	Assert::same($expected, $source);
}

