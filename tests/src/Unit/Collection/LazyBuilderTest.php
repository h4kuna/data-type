<?php declare(strict_types=1);

namespace h4kuna\DataType\Tests\Unit\Collection;

use h4kuna\DataType\Collection\LazyBuilder;
use h4kuna\DataType\Exceptions\InvalidStateException;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @testCase
 */
final class LazyBuilderTest extends TestCase
{
	public function testDefaultIsNotDefinedFailed(): void
	{
		Assert::throws(fn () => (new LazyBuilder())->get('any'), InvalidStateException::class);
		Assert::throws(fn () => (new LazyBuilder())->setDefault('any'), InvalidStateException::class);

		$lazyBuilder = new LazyBuilder();
		$lazyBuilder->setDefault(fn () => 'hello');;
		Assert::throws(fn () => $lazyBuilder->setDefault(fn () => 'any'), InvalidStateException::class);
	}


	public function testFormats(): void
	{
		$lazyBuilder = new LazyBuilder([
			'CZK' => 'Kč',
			'EUR' => static fn (): string => '€',
		]);
		$lazyBuilder->add('GBP', '£');
		$lazyBuilder->setDefault(static fn (string|int $key): string => "-$key-");

		Assert::true($lazyBuilder->has('EUR')); // live
		Assert::true($lazyBuilder->has('CZK')); // factories
		Assert::false($lazyBuilder->has('usd'));

		Assert::same('Kč', $lazyBuilder->get('CZK'));
		Assert::same('€', $lazyBuilder->get('EUR'));
		Assert::same('£', $lazyBuilder->get('GBP'));
		Assert::same('-unknown-', $lazyBuilder->get('unknown'));

		$lazyBuilder->add('CZK', static fn (): string => 'Kčs');
		Assert::same('Kčs', $lazyBuilder->get('CZK'));
	}
}

(new LazyBuilderTest())->run();
