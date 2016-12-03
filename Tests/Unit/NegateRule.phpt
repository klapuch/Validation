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

final class NegateRule extends Tester\TestCase {
	public function testNegateSatisfiedRule() {
		Assert::false(
			(new Validation\NegateRule(
				new Validation\FakeRule(true)
			))->satisfied('abc')
		);
	}

	public function testNegateRefusedRule() {
		Assert::true(
			(new Validation\NegateRule(
				new Validation\FakeRule(false)
			))->satisfied('abc')
		);
	}
}


(new NegateRule())->run();
