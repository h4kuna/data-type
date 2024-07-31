<?php declare(strict_types=1);

namespace h4kuna\DataType\Tests\Unit\Date;

use h4kuna\DataType\Date\Easter;
use h4kuna\Memoize;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @testCase
 */
final class EasterTest extends TestCase
{
	protected function setUp()
	{
		Easter::$useNative = null;
		parent::setUp();
	}


	public function testEaster(): void
	{
		$format = 'Y-m-d';
		Assert::same('2023-04-07', Easter::friday(2023)->format($format));
		Assert::same('2023-04-09', Easter::sunday(2023)->format($format));
		Assert::same('2023-04-10', Easter::monday(2023)->format($format));
		Assert::same(date('Y'), Easter::monday()->format('Y'));
	}


	public function testCompareNativeAndCounted(): void
	{
		for ($i = 1970; $i <= 2037; ++$i) {
			Easter::$useNative = true;
			$native = Easter::sunday($i);


			Easter::$useNative = false;
			$counted = Easter::sunday($i);

			Assert::equal($native, $counted);
		}
	}

}

Memoize\Helper::bypassMemoize();
(new EasterTest())->run();
