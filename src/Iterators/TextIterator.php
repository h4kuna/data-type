<?php declare(strict_types=1);

namespace h4kuna\DataType\Iterators;

use h4kuna\DataType\Basic\BitwiseOperations;
use Nette\Utils\Strings;

/**
 * Iterate via line
 * @template TValue
 * @extends \ArrayIterator<int, TValue>
 */
class TextIterator extends \ArrayIterator
{
	public const SKIP_EMPTY_LINE = 1048576; // 2^20
	public const CSV_MODE = 2097152; // 2^21
	public const SKIP_FIRST_LINE = 4194304; // 2^22
	public const TRIM_LINE = 8388608; // 2^23
	public const SKIP_EMPTY_AND_TRIM_LINE = self::TRIM_LINE | self::SKIP_EMPTY_LINE;

	private string $_current = '';

	private int $flags = 0;

	/** @var array{delimiter: string, enclosure: string, escape: string} */
	private array $csv = [
		'delimiter' => ',',
		'enclosure' => '"',
		'escape' => '\\',
	];


	/**
	 * @param array<string|null>|string $text
	 */
	public function __construct(array|string $text)
	{
		parent::__construct(is_array($text) ? $text : self::text2Array($text));
	}


	/**
	 * Active csv parser.
	 */
	public function setCsv(string $delimiter = ',', string $enclosure = '"', string $escape = '\\'): static
	{
		$this->setFlags($this->getFlags() | self::SKIP_EMPTY_LINE | self::CSV_MODE | self::TRIM_LINE);
		$this->csv = [
			'delimiter' => $delimiter,
			'enclosure' => $enclosure,
			'escape' => $escape,
		];

		return $this;
	}


	/**
	 * @return array<string>
	 */
	private static function text2Array(string $text): array
	{
		$existsNewMethod = method_exists(Strings::class, 'unixNewLines'); // @phpstan-ignore-line
		return explode("\n", $existsNewMethod
			? Strings::unixNewLines($text)
			: Strings::normalizeNewLines($text)
		);
	}


	/**
	 * Change API behavior *****************************************************
	 * *************************************************************************
	 */

	public function setFlags(int $flags): void
	{
		parent::setFlags($flags);
		$this->flags = $flags;
	}


	public function getFlags(): int
	{
		return parent::getFlags() | $this->flags;
	}


	/** @return TValue */
	public function current(): mixed
	{
		$content = $this->_current;
		if (BitwiseOperations::check($this->getFlags(), self::CSV_MODE)) {
			$result = str_getcsv($content, $this->csv['delimiter'], $this->csv['enclosure'], $this->csv['escape']);

			return $result;
		}

		return $content;
	}


	public function rewind(): void
	{
		parent::rewind();
		if ($this->valid() && BitwiseOperations::check($this->getFlags(), self::SKIP_FIRST_LINE)) {
			$this->next();
		}
	}


	public function valid(): bool
	{
		$flags = $this->getFlags();
		do {
			if (parent::valid() === false) {
				return false;
			}
			$current = parent::current();
			assert(is_string($current));
			$this->_current = $current;
			if (BitwiseOperations::check($flags, self::TRIM_LINE)) {
				$this->_current = trim($this->_current);
			}
		} while (BitwiseOperations::check($flags, self::SKIP_EMPTY_LINE) && $this->_current === '' && $this->moveInternalPointer());

		return true;
	}


	private function moveInternalPointer(): bool
	{
		$this->next();

		return true;
	}

}
