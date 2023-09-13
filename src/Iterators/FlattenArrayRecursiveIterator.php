<?php declare(strict_types=1);

namespace h4kuna\DataType\Iterators;

/**
 * @extends \RecursiveIteratorIterator<FlattenArrayIterator>
 */
final class FlattenArrayRecursiveIterator extends \RecursiveIteratorIterator
{

	/**
	 * @param array<mixed> $data
	 */
	public function __construct(array $data, string $delimiter = '-')
	{
		parent::__construct(new FlattenArrayIterator($data, $delimiter));
	}

}
