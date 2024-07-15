<?php declare(strict_types=1);

namespace h4kuna\DataType\Tests\Unit\Iterators;

use h4kuna;
use h4kuna\DataType\Iterators\TextIterator;
use SplFileObject;

require __DIR__ . '/bootstrap.php';

/**
 * @testCase
 */
final class TextIteratorTest extends \Tester\TestCase
{

	public function testNoSetup(): void
	{
		$compare = createTextIterator(TextIterator::NoSetup);
		assertContent('noSetup', toString($compare));
	}


	public function testSkipEmpty(): void
	{
		$compare = createTextIterator(TextIterator::KeepEmptyLine);
		assertContent('keepEmptyLine', toString($compare));
	}


	public function testSkipEmptyTrim(): void
	{
		$compare = createTextIterator(TextIterator::KeepEmptyLine | TextIterator::SkipTrimLine);
		assertContent('keepEmptyLineAndSkipTrim', toString($compare));
	}


	/**
	 * @throws h4kuna\DataType\Exceptions\InvalidStateException
	 */
	public function testFileObjectAsCsv(): void
	{
		$file = new SplFileObject(filepath());
		$file->setFlags(SplFileObject::READ_CSV);
		$file->setCsvControl(';');
		$textIterator = new TextIterator($file);

		toString($textIterator);
	}
}

(new TextIteratorTest)->run();
