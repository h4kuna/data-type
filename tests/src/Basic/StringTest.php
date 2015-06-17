<?php

namespace h4kuna\DataType\Basic;

class StringTest extends \PHPUnit_Framework_TestCase
{

	public function testToFloat()
	{
		$this->assertSame(1.1, String::toFloat('1.1'));
	}

	public function testToInt()
	{
		$this->assertSame(1, String::toInt('1'));
	}

	public function testToGps()
	{
		$coordinate = String::toGps('51.1, 14.1');
		array_walk($coordinate, function(&$v) {
			$v = (string) round($v, 1);
		});
		$this->assertSame(array('51.1', '14.1'), $coordinate);
	}

	public function testToSet()
	{
		$this->assertSame(array('foo' => TRUE, 'bar' => TRUE), String::toSet('foo,bar'));
	}

	public function testToUnderscore()
	{
		$tests = array(
			'startMIDDLELast' => 'start_middle_last',
			'simpleXML' => 'simple_xml',
			'PDFLoad' => 'pdf_load',
			'simpleTest' => 'simple_test',
			'easy' => 'easy',
			'HTML' => 'html',
			'AString' => 'a_string',
			'Some4Numbers234' => 'some4_numbers234',
			'TEST123String' => 'test123_string',
		);
		foreach ($tests as $value => $expeted) {
			$this->assertSame($expeted, String::toUnderscore($value));
		}
	}

	public function testToCamel()
	{
		$tests = array(
			'start_middle_last' => 'startMiddleLast',
			'simple_xml' => 'simpleXml',
			'pdf_load' => 'pdfLoad',
			'simple_test' => 'simpleTest',
			'easy' => 'easy',
			'html' => 'html',
			'a_string' => 'aString',
			'some4_numbers234' => 'some4Numbers234',
			'test123_string' => 'test123String',
		);
		foreach ($tests as $value => $expeted) {
			$this->assertSame($expeted, String::toCamel($value));
		}
	}

}
