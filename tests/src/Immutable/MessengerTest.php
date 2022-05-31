<?php

namespace h4kuna\DataType\Immutable;

use h4kuna\DataType;
use Tester\Assert;

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


	public function testAdd()
	{
		$messenger = new Messenger([]);
		$clone = $messenger->add('foo', 'bar');
		Assert::notSame($messenger, $clone);
		Assert::false(isset($messenger->foo));
		Assert::type('h4kuna\DataType\Immutable\Messenger', $clone);
	}


	public function testExists()
	{
		$messenger = new Messenger(['foo' => 'bar', 'doe' => null]);
		Assert::true($messenger->exists('doe'));
		Assert::false($messenger->exists('baz'));
	}


	public function testSet()
	{
		$messenger = new Messenger([]);

		Assert::exception(function () use ($messenger) {
			$messenger->foo = 'bar';
		}, DataType\Exceptions\LogicException::class);

		Assert::exception(function () use ($messenger) {
			$messenger['foo'] = 'bar';
		}, DataType\Exceptions\LogicException::class);
	}


	public function testUnset()
	{
		$messenger = new Messenger(['foo' => 'bar', 'doe' => 'joe']);

		Assert::exception(function () use ($messenger) {
			unset($messenger['foo']);
		}, DataType\Exceptions\LogicException::class);

		Assert::exception(function () use ($messenger) {
			unset($messenger->foo);
		}, DataType\Exceptions\LogicException::class);

		$clone = $messenger->remove('foo', 'doe');
		Assert::notSame($messenger, $clone);
		Assert::same(0, count($clone));

		Assert::same('bar', $messenger->foo);
	}


	public function testIsset()
	{
		$messenger = new Messenger([
			'bar' => null,
			'foo' => 'yes',
		]);

		Assert::false(isset($messenger->baz));
		Assert::false(isset($messenger['baz']));
		Assert::false(isset($messenger->bar));
		Assert::false(isset($messenger['bar']));

		Assert::true(isset($messenger->foo));
		Assert::true(isset($messenger['foo']));
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
