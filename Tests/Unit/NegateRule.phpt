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
		list($rule, $subject) = [new Validation\FakeRule(true), 'abc'];
		Assert::false((new Validation\NegateRule($rule))->satisfied($subject));
		Assert::exception(function() use($rule, $subject) {
			(new Validation\NegateRule($rule))->apply($subject);
		}, \UnexpectedValueException::class, 'The rule is not applicable');
	}

	public function testNegateRefusedRule() {
		list($rule, $subject) = [new Validation\FakeRule(false), 'abc'];
		Assert::true((new Validation\NegateRule($rule))->satisfied($subject));
		Assert::noError(function() use($rule, $subject) {
			(new Validation\NegateRule($rule))->apply($subject);
		});
	}
}


(new NegateRule())->run();