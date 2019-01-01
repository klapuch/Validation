<?php
declare(strict_types = 1);

/**
 * @testCase
 * @phpVersion > 7.1
 */

namespace Klapuch\Validation\Unit;

use Klapuch\Validation;
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class NumericRule extends Tester\TestCase {
	public function testUnrealNumbers(): void {
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

	public function testNumericSubjects(): void {
		Assert::true((new Validation\NumericRule())->satisfied(-1));
		Assert::true((new Validation\NumericRule())->satisfied(-1.5));
		Assert::true((new Validation\NumericRule())->satisfied(0.44));
		Assert::true((new Validation\NumericRule())->satisfied(0));
		Assert::true((new Validation\NumericRule())->satisfied(4));
		Assert::true((new Validation\NumericRule())->satisfied(PHP_INT_MAX));
	}

	public function testNumericStringSubjects(): void {
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

	public function testUnknownNumericSubjects(): void {
		Assert::false((new Validation\NumericRule())->satisfied('foo'));
		Assert::false((new Validation\NumericRule())->satisfied(false));
		Assert::false((new Validation\NumericRule())->satisfied(true));
		Assert::false((new Validation\NumericRule())->satisfied(null));
		Assert::false((new Validation\NumericRule())->satisfied([]));
		Assert::false((new Validation\NumericRule())->satisfied(md5('foo')));
	}

	public function testMixedDigitsWithLetters(): void {
		Assert::false((new Validation\NumericRule())->satisfied('4foo'));
		Assert::false((new Validation\NumericRule())->satisfied('foo4'));
		Assert::false((new Validation\NumericRule())->satisfied('4foo4'));
		Assert::false((new Validation\NumericRule())->satisfied('fo4o'));
	}

	public function testApplications(): void {
		Assert::same(123, (new Validation\NumericRule())->apply(123));
		Assert::exception(static function(): void {
			(new Validation\NumericRule())->apply('foo');
		}, \UnexpectedValueException::class, 'Subject is not numeric');
	}
}


(new NumericRule())->run();
