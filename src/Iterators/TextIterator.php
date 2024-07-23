<?php declare(strict_types=1);

namespace h4kuna\DataType\Iterators;

use Generator;
use h4kuna\DataType\Basic\Arrays;
use h4kuna\DataType\Basic\BitwiseOperations;
use h4kuna\DataType\Exceptions\InvalidStateException;
use IteratorAggregate;
use SplFileObject;

/**
 * Iterate via line
 * @template TValue of string|non-empty-string
 * @implements IteratorAggregate<int, TValue>
 * @phpstan-type VIterable array<scalar|null>|SplFileObject
 */
final class TextIterator implements IteratorAggregate
{
	public const NoSetup = 0;
	public const KeepEmptyLine = 1;
	public const SkipFirstLine = 2;
	public const SkipTrimLine = 4;

	/** @var VIterable */
	private array|SplFileObject $data;


	/**
	 * @param VIterable|string $text
	 * @param int $flags , trim line and skip empty line by default
	 */
	public function __construct(
		array|string|SplFileObject $text,
		private int $flags = self::NoSetup
	)
	{
		$this->data = is_string($text) ? Arrays::text2Array($text) : $text;
	}


	/**
	 * @return Generator<int, TValue>
	 */
	public function getIterator(): Generator
	{
		$isTrimEnabled = BitwiseOperations::check($this->flags, self::SkipTrimLine) === false;
		$skipEmptyLine = BitwiseOperations::check($this->flags, self::KeepEmptyLine) === false;

		if ($this->data instanceof SplFileObject) {
			if (BitwiseOperations::check($this->data->getFlags(), SplFileObject::READ_CSV)) {
				throw new InvalidStateException('SplFileObject is in csv read mode. Let\'s disable it and use CsvIterator() instead.');
			}
			$first = 0;
		} else {
			$first = array_key_first($this->data);
		}

		foreach ($this->data as $key => $row) {
			if ($first === $key && BitwiseOperations::check($this->flags, self::SkipFirstLine)) {
				continue;
			}
			assert(is_array($row) === false);

			$strRow = (string) $row;

			if ($isTrimEnabled) {
				$strRow = trim($strRow);
			}

			if ($skipEmptyLine && $strRow === '') {
				continue;
			}

			/** @var TValue $strRow */
			yield $key => $strRow;
		}
	}
}
