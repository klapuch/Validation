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

final class SameRule extends Tester\TestCase {
	public function testSameValue() {
		Assert::true((new Validation\SameRule(1))->satisfied(1));
		Assert::true((new Validation\SameRule('abc'))->satisfied('abc'));
	}

	public function testNotSameForCaseInsensitiveOne() {
		Assert::false((new Validation\SameRule('abc'))->satisfied('ABC'));
	}

	public function testUsingStrictDataTypeComparison() {
		Assert::false((new Validation\SameRule(true))->satisfied(1));
		Assert::false((new Validation\SameRule(new \stdClass()))->satisfied(new \stdClass()));
	}

	public function testApplication() {
		Assert::same(1, (new Validation\SameRule(1))->apply(1));
		Assert::exception(function() {
			(new Validation\SameRule('Hi'))->apply('Hello');
		}, \UnexpectedValueException::class, '"Hi" is not same as "Hello"');
	}
}


(new SameRule())->run();