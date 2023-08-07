<?php declare(strict_types=1);

namespace h4kuna\DataType\Tests\Unit\Collection;

use h4kuna\DataType\Collection\StrictTypeArray;
use h4kuna\DataType\Exceptions\InvalidTypeException;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @testCase
 */
final class StrictTypeArrayTest extends TestCase
{

	public function testString(): void
	{
		$types = self::createStrictTypeArray();

		Assert::same('', $types->string('a'));
		Assert::same('', $types->string('b'));
		Assert::same('foo', $types->string('c'));
		Assert::same('0', $types->string('d'));
		Assert::same('0.0', $types->string('e'));
		Assert::same('0.', $types->string('f'));
		Assert::same('.0', $types->string('g'));
		Assert::same('1.5', $types->string('h'));
		Assert::same('-1.5', $types->string('i'));
		Assert::same('0', $types->string('j'));
		Assert::same('1.5', $types->string('k'));
		Assert::same('-1.5', $types->string('l'));
		Assert::same('0', $types->string('m'));
		Assert::same('1', $types->string('n'));
		Assert::same('-1', $types->string('o'));
		Assert::exception(fn () => $types->string('p'), InvalidTypeException::class);
		Assert::exception(fn () => $types->string('q'), InvalidTypeException::class);
		Assert::exception(fn () => $types->string('r'), InvalidTypeException::class);
		Assert::exception(fn () => $types->string('s'), InvalidTypeException::class);
		Assert::exception(fn () => $types->string('z'), InvalidTypeException::class);
	}


	public function testStringNull(): void
	{
		$types = self::createStrictTypeArray();

		Assert::null($types->stringNull('a'));
		Assert::same('', $types->stringNull('b'));
		Assert::same('foo', $types->stringNull('c'));
		Assert::same('0', $types->stringNull('d'));
		Assert::same('0.0', $types->stringNull('e'));
		Assert::same('0.', $types->stringNull('f'));
		Assert::same('.0', $types->stringNull('g'));
		Assert::same('1.5', $types->stringNull('h'));
		Assert::same('-1.5', $types->stringNull('i'));
		Assert::same('0', $types->stringNull('j'));
		Assert::same('1.5', $types->stringNull('k'));
		Assert::same('-1.5', $types->stringNull('l'));
		Assert::same('0', $types->stringNull('m'));
		Assert::same('1', $types->stringNull('n'));
		Assert::same('-1', $types->stringNull('o'));
		Assert::exception(fn () => $types->stringNull('p'), InvalidTypeException::class);
		Assert::exception(fn () => $types->stringNull('q'), InvalidTypeException::class);
		Assert::exception(fn () => $types->stringNull('r'), InvalidTypeException::class);
		Assert::exception(fn () => $types->stringNull('s'), InvalidTypeException::class);
		Assert::null($types->stringNull('z'));
	}


	public function testFloat(): void
	{
		$types = self::createStrictTypeArray();

		Assert::same(0.0, $types->float('a'));
		Assert::same(0.0, $types->float('b'));
		Assert::exception(fn () => $types->float('c'), InvalidTypeException::class);
		Assert::same(0.0, $types->float('d'));
		Assert::same(0.0, $types->float('e'));
		Assert::same(0.0, $types->float('f'));
		Assert::same(0.0, $types->float('g'));
		Assert::same(1.5, $types->float('h'));
		Assert::same(-1.5, $types->float('i'));
		Assert::same(0.0, $types->float('j'));
		Assert::same(1.5, $types->float('k'));
		Assert::same(-1.5, $types->float('l'));
		Assert::same(0.0, $types->float('m'));
		Assert::same(1.0, $types->float('n'));
		Assert::same(-1.0, $types->float('o'));
		Assert::exception(fn () => $types->float('p'), InvalidTypeException::class);
		Assert::exception(fn () => $types->float('q'), InvalidTypeException::class);
		Assert::same(1.0, $types->float('r'));
		Assert::same(0.0, $types->float('s'));
		Assert::exception(fn () => $types->float('z'), InvalidTypeException::class);
	}


	public function testFloatNull(): void
	{
		$types = self::createStrictTypeArray();

		Assert::null($types->floatNull('a'));
		Assert::same(0.0, $types->floatNull('b'));
		Assert::exception(fn () => $types->floatNull('c'), InvalidTypeException::class);
		Assert::same(0.0, $types->floatNull('d'));
		Assert::same(0.0, $types->floatNull('e'));
		Assert::same(0.0, $types->floatNull('f'));
		Assert::same(0.0, $types->floatNull('g'));
		Assert::same(1.5, $types->floatNull('h'));
		Assert::same(-1.5, $types->floatNull('i'));
		Assert::same(0.0, $types->floatNull('j'));
		Assert::same(1.5, $types->floatNull('k'));
		Assert::same(-1.5, $types->floatNull('l'));
		Assert::same(0.0, $types->floatNull('m'));
		Assert::same(1.0, $types->floatNull('n'));
		Assert::same(-1.0, $types->floatNull('o'));
		Assert::exception(fn () => $types->floatNull('p'), InvalidTypeException::class);
		Assert::exception(fn () => $types->floatNull('q'), InvalidTypeException::class);
		Assert::same(1.0, $types->floatNull('r'));
		Assert::same(0.0, $types->floatNull('s'));
		Assert::null($types->floatNull('z'));
	}


	public function testInt(): void
	{
		$types = self::createStrictTypeArray();

		Assert::same(0, $types->int('a'));
		Assert::same(0, $types->int('b'));
		Assert::exception(fn () => $types->int('c'), InvalidTypeException::class);
		Assert::same(0, $types->int('d'));
		Assert::same(0, $types->int('e'));
		Assert::same(0, $types->int('f'));
		Assert::same(0, $types->int('g'));
		Assert::exception(fn () => $types->int('h'), InvalidTypeException::class);
		Assert::exception(fn () => $types->int('i'), InvalidTypeException::class);
		Assert::same(0, $types->int('j'));
		Assert::exception(fn () => $types->int('k'), InvalidTypeException::class);
		Assert::exception(fn () => $types->int('l'), InvalidTypeException::class);
		Assert::same(0, $types->int('m'));
		Assert::same(1, $types->int('n'));
		Assert::same(-1, $types->int('o'));
		Assert::exception(fn () => $types->int('p'), InvalidTypeException::class);
		Assert::exception(fn () => $types->int('q'), InvalidTypeException::class);
		Assert::same(1, $types->int('r'));
		Assert::same(0, $types->int('s'));
		Assert::exception(fn () => $types->int('z'), InvalidTypeException::class);
	}


	public function testIntNull(): void
	{
		$types = self::createStrictTypeArray();

		Assert::null($types->intNull('a'));
		Assert::same(0, $types->intNull('b'));
		Assert::exception(fn () => $types->intNull('c'), InvalidTypeException::class);
		Assert::same(0, $types->intNull('d'));
		Assert::same(0, $types->intNull('e'));
		Assert::same(0, $types->intNull('f'));
		Assert::same(0, $types->intNull('g'));
		Assert::exception(fn () => $types->intNull('h'), InvalidTypeException::class);
		Assert::exception(fn () => $types->intNull('i'), InvalidTypeException::class);
		Assert::same(0, $types->intNull('j'));
		Assert::exception(fn () => $types->intNull('k'), InvalidTypeException::class);
		Assert::exception(fn () => $types->intNull('l'), InvalidTypeException::class);
		Assert::same(0, $types->intNull('m'));
		Assert::same(1, $types->intNull('n'));
		Assert::same(-1, $types->intNull('o'));
		Assert::exception(fn () => $types->intNull('p'), InvalidTypeException::class);
		Assert::exception(fn () => $types->intNull('q'), InvalidTypeException::class);
		Assert::same(1, $types->intNull('r'));
		Assert::same(0, $types->intNull('s'));
		Assert::null($types->intNull('z'));
	}


	public function testArray(): void
	{
		$types = self::createStrictTypeArray();

		Assert::exception(fn () => $types->array('a'), InvalidTypeException::class);
		Assert::exception(fn () => $types->array('b'), InvalidTypeException::class);
		Assert::exception(fn () => $types->array('c'), InvalidTypeException::class);
		Assert::exception(fn () => $types->array('d'), InvalidTypeException::class);
		Assert::exception(fn () => $types->array('e'), InvalidTypeException::class);
		Assert::exception(fn () => $types->array('f'), InvalidTypeException::class);
		Assert::exception(fn () => $types->array('g'), InvalidTypeException::class);
		Assert::exception(fn () => $types->array('h'), InvalidTypeException::class);
		Assert::exception(fn () => $types->array('i'), InvalidTypeException::class);
		Assert::exception(fn () => $types->array('j'), InvalidTypeException::class);
		Assert::exception(fn () => $types->array('k'), InvalidTypeException::class);
		Assert::exception(fn () => $types->array('l'), InvalidTypeException::class);
		Assert::exception(fn () => $types->array('m'), InvalidTypeException::class);
		Assert::exception(fn () => $types->array('n'), InvalidTypeException::class);
		Assert::exception(fn () => $types->array('o'), InvalidTypeException::class);
		Assert::same([], $types->array('p'));
		Assert::same(['foo'], $types->array('q'));
		Assert::exception(fn () => $types->array('r'), InvalidTypeException::class);
		Assert::exception(fn () => $types->array('s'), InvalidTypeException::class);
		Assert::exception(fn () => $types->array('z'), InvalidTypeException::class);
	}


	public function testArrayNull(): void
	{
		$types = self::createStrictTypeArray();

		Assert::null($types->arrayNull('a'));
		Assert::exception(fn () => $types->arrayNull('b'), InvalidTypeException::class);
		Assert::exception(fn () => $types->arrayNull('c'), InvalidTypeException::class);
		Assert::exception(fn () => $types->arrayNull('d'), InvalidTypeException::class);
		Assert::exception(fn () => $types->arrayNull('e'), InvalidTypeException::class);
		Assert::exception(fn () => $types->arrayNull('f'), InvalidTypeException::class);
		Assert::exception(fn () => $types->arrayNull('g'), InvalidTypeException::class);
		Assert::exception(fn () => $types->arrayNull('h'), InvalidTypeException::class);
		Assert::exception(fn () => $types->arrayNull('i'), InvalidTypeException::class);
		Assert::exception(fn () => $types->arrayNull('j'), InvalidTypeException::class);
		Assert::exception(fn () => $types->arrayNull('k'), InvalidTypeException::class);
		Assert::exception(fn () => $types->arrayNull('l'), InvalidTypeException::class);
		Assert::exception(fn () => $types->arrayNull('m'), InvalidTypeException::class);
		Assert::exception(fn () => $types->arrayNull('n'), InvalidTypeException::class);
		Assert::exception(fn () => $types->arrayNull('o'), InvalidTypeException::class);
		Assert::same([], $types->arrayNull('p'));
		Assert::same(['foo'], $types->arrayNull('q'));
		Assert::exception(fn () => $types->arrayNull('r'), InvalidTypeException::class);
		Assert::exception(fn () => $types->arrayNull('s'), InvalidTypeException::class);
		Assert::null($types->arrayNull('z'));
	}


	public function testBool(): void
	{
		$types = self::createStrictTypeArray();

		Assert::false($types->bool('a'));
		Assert::false($types->bool('b'));
		Assert::exception(fn () => $types->bool('c'), InvalidTypeException::class);
		Assert::false($types->bool('d'));
		Assert::false($types->bool('e'));
		Assert::false($types->bool('f'));
		Assert::false($types->bool('g'));
		Assert::exception(fn () => $types->bool('h'), InvalidTypeException::class);
		Assert::exception(fn () => $types->bool('i'), InvalidTypeException::class);
		Assert::false($types->bool('j'));
		Assert::exception(fn () => $types->bool('k'), InvalidTypeException::class);
		Assert::exception(fn () => $types->bool('l'), InvalidTypeException::class);
		Assert::false($types->bool('m'));
		Assert::true($types->bool('n'));
		Assert::exception(fn () => $types->bool('o'), InvalidTypeException::class);
		Assert::exception(fn () => $types->bool('p'), InvalidTypeException::class);
		Assert::exception(fn () => $types->bool('q'), InvalidTypeException::class);
		Assert::true($types->bool('r'));
		Assert::false($types->bool('s'));
		Assert::false($types->bool('z'));
	}


	private static function createStrictTypeArray(): StrictTypeArray
	{
		return new StrictTypeArray([
			'a' => null,
			// string
			'b' => '',
			'c' => 'foo',
			'd' => '0',
			'e' => '0.0',
			'f' => '0.',
			'g' => '.0',
			'h' => '1.5',
			'i' => '-1.5',
			// float
			'j' => 0.0,
			'k' => 1.5,
			'l' => -1.5,
			// int
			'm' => 0,
			'n' => 1,
			'o' => -1,
			// array
			'p' => [],
			'q' => ['foo'],
			// bool
			'r' => true,
			's' => false,
			// 'z' reserved, no filled
		]);
	}
}

(new StrictTypeArrayTest())->run();
