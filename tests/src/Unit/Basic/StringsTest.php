<?php declare(strict_types=1);

namespace h4kuna\DataType\Tests\Unit\Basic;

use h4kuna\DataType;
use h4kuna\DataType\Basic\Strings;
use Tester;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @testCase
 */
final class StringsTest extends Tester\TestCase
{

	public function testToFloat(): void
	{
		Assert::same(1.1, Strings::toFloat('1.1'));
	}


	public function testToInt(): void
	{
		Assert::same(1, Strings::toInt('1'));
	}


	public function testToGps(): void
	{
		$coordinate = Strings::toGps('51.1, 14.1');
		array_walk($coordinate, function (&$v) {
			$v = round(floatval($v), 1);
		});
		Assert::same([51.1, 14.1, 'lat' => 51.1, 'long' => 14.1], $coordinate);
	}


	public function testToSet(): void
	{
		Assert::same(['foo' => true, 'bar' => true], Strings::toSet('foo,bar'));
	}


	public function testToUnderscore(): void
	{
		$tests = [
			'startMIDDLELast' => 'start_middle_last',
			'simpleXML' => 'simple_xml',
			'PDFLoad' => 'pdf_load',
			'simpleTest' => 'simple_test',
			'easy' => 'easy',
			'HTML' => 'html',
			'AString' => 'a_string',
			'Some4Numbers234' => 'some4_numbers234',
			'TEST123String' => 'test123_string',
		];
		foreach ($tests as $value => $expeted) {
			Assert::same($expeted, Strings::toUnderscore($value));
		}
	}


	public function testToCamel(): void
	{
		$tests = [
			'start_middle_last' => 'startMiddleLast',
			'simple_xml' => 'simpleXml',
			'pdf_load' => 'pdfLoad',
			'simple_test' => 'simpleTest',
			'easy' => 'easy',
			'html' => 'html',
			'a_string' => 'aString',
			'some4_numbers234' => 'some4Numbers234',
			'test123_string' => 'test123String',
		];
		foreach ($tests as $value => $expeted) {
			Assert::same($expeted, Strings::toCamel($value));
		}
	}


	public function testToPascal(): void
	{
		$tests = [
			'start_middle_last' => 'StartMiddleLast',
			'simple_xml' => 'SimpleXml',
			'pdf_load' => 'PdfLoad',
			'simple_test' => 'SimpleTest',
			'easy' => 'Easy',
			'a_string' => 'AString',
			'some4_numbers234' => 'Some4Numbers234',
			'test123_string' => 'Test123String',
		];
		foreach ($tests as $value => $expeted) {
			Assert::same($expeted, Strings::toPascal($value));
		}
	}


	protected function providePadIfNeed(): array
	{
		return [
			[
				'/a',
				['a'],
			],
			[
				'/a',
				['/a'],
			],
			[
				'/a/',
				['a', 'padType' => STR_PAD_BOTH],
			],
			[
				'/a/',
				['/a/', 'padType' => STR_PAD_BOTH],
			],
			[
				'/a/',
				['a/', 'padType' => STR_PAD_BOTH],
			],
			[
				'/a/',
				['/a', 'padType' => STR_PAD_BOTH],
			],
			[
				'a/',
				['a', 'padType' => STR_PAD_RIGHT],
			],
			[
				'a/',
				['a/', 'padType' => STR_PAD_RIGHT],
			],
			[
				'kůňůůůkůň',
				['ůůů', 'padString' => 'kůň', 'padType' => STR_PAD_BOTH],
			],
			[
				'kůňůůůkůň',
				['kůňůůůkůň', 'padString' => 'kůň', 'padType' => STR_PAD_BOTH],
			],
		];
	}


	/**
	 * @dataProvider providePadIfNeed
	 */
	public function testPadIfNeed(string $expected, array $input): void
	{
		Assert::same($expected, Strings::padIfNeed(...$input));
	}

}

(new StringsTest())->run();
