<?php declare(strict_types=1);

namespace h4kuna\DataType\Iterators;

use Generator;
use IteratorAggregate;
use SplFileObject;

/**
 * @implements IteratorAggregate<int, array<string>>
 */
class CsvIterator implements IteratorAggregate
{
	/** @var TextIterator<string|non-empty-string> */
	private TextIterator $textIterator;


	/**
	 * @param array<scalar|null>|string|SplFileObject|TextIterator<string|non-empty-string> $text
	 */
	public function __construct(
		array|string|SplFileObject|TextIterator $text,
		private string $delimiter = ',',
		private string $enclosure = '"',
		private string $escape = '\\',
		int $flags = TextIterator::NoSetup,
	)
	{
		if ($text instanceof TextIterator) {
			$this->textIterator = $text;
		} else {
			$this->textIterator = new TextIterator($text, $flags);
		}
	}


	/**
	 * @return Generator<int, array<string>>
	 */
	public function getIterator(): Generator
	{
		foreach ($this->textIterator as $k => $strRow) {
			/** @var array<string> $data */
			$data = str_getcsv($strRow, $this->delimiter, $this->enclosure, $this->escape);
			yield $k => $data;
		}
	}
}
