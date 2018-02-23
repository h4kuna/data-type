<?php

namespace h4kuna\DataType\Immutable;

use h4kuna\DataType,
	Tester\Assert;

include __DIR__ . '/../../bootstrap.php';

class MessengerTest extends \Tester\TestCase
{

	public function testBasic()
	{
		$messenger = new Messenger([
			'foo' => 'bar',
			'doe' => 'joe',
		]);

		Assert::same('bar', $messenger->foo);
		Assert::same('joe', $messenger->doe);

		Assert::same('bar', $messenger['foo']);
		Assert::same('joe', $messenger['doe']);
	}

	public function testSet()
	{
		$messenger = new Messenger([]);
		$clone = $messenger->foo = 'bar';
		Assert::notSame($messenger, $clone);
		Assert::false(isset($messenger->foo));

		$clone2 = $messenger['foo'] = 'bar';
		Assert::notSame($messenger, $clone2);
	}

	public function testUnset()
	{
		$messenger = new Messenger(['foo' => 'bar', 'doe' => 'joe']);

		Assert::exception(function () use ($messenger) {
			unset($messenger['foo']);
		}, 'h4kuna\DataType\LogicException');

		Assert::exception(function () use ($messenger) {
			unset($messenger->foo);
		}, 'h4kuna\DataType\LogicException');

		$clone = $messenger->remove('foo', 'doe');
		Assert::notSame($messenger, $clone);
		Assert::same(0, count($clone));

		Assert::same('bar', $messenger->foo);
	}

	public function testIsset()
	{
		$messenger = new Messenger([
			'bar' => null,
		]);

		Assert::false(isset($messenger->foo));
		Assert::false(isset($messenger['foo']));
		Assert::false(isset($messenger->bar));
		Assert::true(isset($messenger['bar']));
	}

	public function testSerialize()
	{
		$messenger = new Messenger([
			'bar' => 'foo',
		]);

		$serializeMessenger = serialize($messenger);
		Assert::equal($messenger, unserialize($serializeMessenger));
	}

	public function testJsonSerialize()
	{
		$messenger = new Messenger([
			'bar' => 'foo',
		]);

		$serializeMessenger = json_encode($messenger);

		$expected = new \stdClass();
		$expected->bar = 'foo';
		Assert::equal($expected, json_decode($serializeMessenger));
	}

	public function testCount()
	{
		$messenger = new Messenger([
			'foo' => 'bar',
			'doe' => 'joe',
		]);
		Assert::same(2, count($messenger));
	}

	public function testIterator()
	{
		$messenger = new Messenger([
			'foo' => 'bar',
			'doe' => 'joe',
		]);

		$data = [];
		foreach ($messenger as $key => $value) {
			$data[$key] = $value;
		}
		Assert::same([
			'foo' => 'bar',
			'doe' => 'joe',
		], $data);
		Assert::same($messenger->getData(), $data);
	}
}

(new MessengerTest)->run();
