<?php

namespace h4kuna\DataType\Basic;

use h4kuna\DataType,
	Tester\Assert;

include __DIR__ . '/../../bootstrap.php';

class StringsTest extends \Tester\TestCase
{

	public function testToFloat()
	{
		Assert::same(1.1, Strings::toFloat('1.1'));
	}

	public function testToInt()
	{
		Assert::same(1, Strings::toInt('1'));
	}

	public function testToGps()
	{
		$coordinate = Strings::toGps('51.1, 14.1');
		array_walk($coordinate, function (&$v) {
			$v = (string) round($v, 1);
		});
		Assert::same(['51.1', '14.1'], $coordinate);
	}

	public function testToSet()
	{
		Assert::same(['foo' => TRUE, 'bar' => TRUE], Strings::toSet('foo,bar'));
	}

	public function testToUnderscore()
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

	public function testToCamel()
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

	public function testToPascal()
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

}

(new StringsTest())->run();