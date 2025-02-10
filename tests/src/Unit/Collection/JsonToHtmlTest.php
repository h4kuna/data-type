<?php declare(strict_types=1);

namespace h4kuna\DataType\Tests\Unit\Collection;

use h4kuna\DataType\Collection\JsonToHtml;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../../../bootstrap.php';

final class JsonToHtmlTest extends TestCase
{
	public function testMain(): void
	{
		$config = self::createJsonToHtml();
		Assert::same('<script type="text/json" id="test-config">{"foo":"","bar":0,"baz":0.0,"is":false}</script>', (string) $config);

		$config->bar = 1; // @phpstan-ignore-line
		$config->foo = 'lorem ipsum'; // @phpstan-ignore-line
		Assert::same('<script type="text/json" id="test-config">{"foo":"lorem ipsum","bar":1,"baz":0.0,"is":false}</script>', (string) $config);
	}


	private static function createJsonToHtml(): JsonToHtml
	{
		return new class('test-config') extends JsonToHtml {
			public string $foo = '';

			public int $bar = 0;

			public float $baz = 0.0;

			public bool $is = false;
		};
	}
}

(new JsonToHtmlTest())->run();
