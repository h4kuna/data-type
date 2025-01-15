<?php declare(strict_types=1);

namespace
{
	use h4kuna\DataType\Iterators\ReverseIterator;

	if (!function_exists('_')) {
		function _(string $message): string
		{
			return $message;
		}
	}

	class_alias(ReverseIterator::class, 'h4kuna\\DataType\\Iterators\\ReverseArray');
}

namespace h4kuna\DataType\Iterators
{

	if (false) { // @phpstan-ignore-line
		/**
		 * @deprecated use ReverseIterator
		 * @see ReverseIterator
		 */
		class ReverseArray
		{
		}
	}
}
