<?php declare(strict_types=1);

namespace h4kuna\DataType\Tests\Unit\Iterators;

use h4kuna\DataType\Iterators\CsvIterator;
use h4kuna\DataType\Iterators\TextIterator;

require __DIR__ . '/bootstrap.php';

/**
 * @testCase
 */
final class CsvIteratorTest extends \Tester\TestCase
{
	public function testFileObject(): void
	{
		$csvIterator = new CsvIterator(new \SplFileObject(filepath()));
		assertContent('fileObject', toString($csvIterator));
	}

	public function testCsvWithHead(): void
	{
		$csvIterator = new CsvIterator(createTextIterator(TextIterator::NoSetup), ';');
		assertContent('csvNoSetUp', toString($csvIterator));
	}
	public function testCsv(): void
	{
		$csvIterator = new CsvIterator(createTextIterator(TextIterator::SkipFirstLine), ';');
		assertContent('csvSkipFirstLine', toString($csvIterator));
	}

}

(new CsvIteratorTest)->run();
