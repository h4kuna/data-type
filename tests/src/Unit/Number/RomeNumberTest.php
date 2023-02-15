<?php declare(strict_types=1);

namespace h4kuna\DataType\Tests\Unit\Number;

use h4kuna\DataType;
use h4kuna\DataType\Number\RomeNumber;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @testCase
 */
final class RomeNumberTest extends \Tester\TestCase
{

	public function testArabic(): void
	{
		Assert::same(1090, RomeNumber::getArabic('MXC'));
	}


	public function testRome(): void
	{
		Assert::same('MXC', RomeNumber::getRome(1090));
	}

}

(new RomeNumberTest())->run();
