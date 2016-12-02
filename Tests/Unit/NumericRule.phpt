<?php
/**
 * @testCase
 * @phpVersion > 7.1
 */
namespace Klapuch\Validation\Unit;

use Tester;
use Tester\Assert;
use Klapuch\Validation;

require __DIR__ . '/../bootstrap.php';

final class NumericRule extends Tester\TestCase {
	public function testUnrealNumbers() {
		Assert::false((new Validation\NumericRule())->satisfied(PHP_INT_MAX + 9));
		Assert::false((new Validation\NumericRule())->satisfied(3e3434));
		Assert::false((new Validation\NumericRule())->satisfied('3e3434'));
		Assert::false((new Validation\NumericRule())->satisfied('3E3434'));
		Assert::true(
			(new Validation\NumericRule())->satisfied(
				sprintf('%s99999', PHP_INT_MAX)
			)
		);
		Assert::false((new Validation\NumericRule())->satisfied('3e3434'));
		Assert::false((new Validation\NumericRule())->satisfied('e3434'));
		Assert::false((new Validation\NumericRule())->satisfied('3E3434'));
		Assert::false((new Validation\NumericRule())->satisfied('E3434'));
		Assert::false((new Validation\NumericRule())->satisfied(INF));
		Assert::false((new Validation\NumericRule())->satisfied('INF'));
		Assert::false((new Validation\NumericRule())->satisfied(-INF));
		Assert::false((new Validation\NumericRule())->satisfied('-INF'));
	}

	public function testNumericSubjects() {
		Assert::true((new Validation\NumericRule())->satisfied(-1));
		Assert::true((new Validation\NumericRule())->satisfied(-1.5));
		Assert::true((new Validation\NumericRule())->satisfied(0.44));
		Assert::true((new Validation\NumericRule())->satisfied(0));
		Assert::true((new Validation\NumericRule())->satisfied(4));
		Assert::true((new Validation\NumericRule())->satisfied(PHP_INT_MAX));
	}

	public function testNumericStringSubjects() {
		Assert::true((new Validation\NumericRule())->satisfied('-1'));
		Assert::true((new Validation\NumericRule())->satisfied('-1.5'));
		Assert::true((new Validation\NumericRule())->satisfied('0.44'));
		Assert::true((new Validation\NumericRule())->satisfied('0'));
		Assert::true((new Validation\NumericRule())->satisfied('4'));
		Assert::true(
			(new Validation\NumericRule())->satisfied(
				sprintf('%s', PHP_INT_MAX)
			)
		);
	}

	public function testUnknownNumericSubjects() {
		Assert::false((new Validation\NumericRule())->satisfied('foo'));
		Assert::false((new Validation\NumericRule())->satisfied(false));
		Assert::false((new Validation\NumericRule())->satisfied(true));
		Assert::false((new Validation\NumericRule())->satisfied(null));
		Assert::false((new Validation\NumericRule())->satisfied([]));
		Assert::false((new Validation\NumericRule())->satisfied(md5('foo')));
	}

	public function testMixedDigitsWithLetters() {
		Assert::false((new Validation\NumericRule())->satisfied('4foo'));
		Assert::false((new Validation\NumericRule())->satisfied('foo4'));
		Assert::false((new Validation\NumericRule())->satisfied('4foo4'));
		Assert::false((new Validation\NumericRule())->satisfied('fo4o'));
	}
}


(new NumericRule())->run();
