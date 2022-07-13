<?php

namespace h4kuna\DataType\Immutable;

use h4kuna\DataType;
use Tester\Assert;

include __DIR__ . '/../../bootstrap.php';

final class MessengerTest extends \Tester\TestCase
{

	public function testBasic(): void
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


	public function testAdd(): void
	{
		$messenger = new Messenger([]);
		$clone = $messenger->add('foo', 'bar');
		Assert::notSame($messenger, $clone);
		Assert::false(isset($messenger->foo));
		Assert::type('h4kuna\DataType\Immutable\Messenger', $clone);
	}


	public function testExists(): void
	{
		$messenger = new Messenger(['foo' => 'bar', 'doe' => null]);
		Assert::true($messenger->exists('doe'));
		Assert::false($messenger->exists('baz'));
	}


	public function testSet(): void
	{
		$messenger = new Messenger([]);

		Assert::exception(function () use ($messenger) {
			$messenger->foo = 'bar';
		}, DataType\Exceptions\LogicException::class);

		Assert::exception(function () use ($messenger) {
			$messenger['foo'] = 'bar';
		}, DataType\Exceptions\LogicException::class);
	}


	public function testUnset(): void
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


	public function testIsset(): void
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


	public function testSerialize(): void
	{
		$messenger = new Messenger([
			'bar' => 'foo',
		]);

		$serializeMessenger = serialize($messenger);
		Assert::equal($messenger, unserialize($serializeMessenger));
	}


	public function testJsonSerialize(): void
	{
		$messenger = new Messenger([
			'bar' => 'foo',
		]);

		$serializeMessenger = json_encode($messenger);

		$expected = new \stdClass();
		$expected->bar = 'foo';
		Assert::equal($expected, json_decode($serializeMessenger));
	}


	public function testCount(): void
	{
		$messenger = new Messenger([
			'foo' => 'bar',
			'doe' => 'joe',
		]);
		Assert::same(2, count($messenger));
	}


	public function testIterator(): void
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
