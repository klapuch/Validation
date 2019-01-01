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

final class NegateRule extends Tester\TestCase {
	public function testNegateSatisfiedRule(): void {
		[$rule, $subject] = [new Validation\FakeRule(true), 'abc'];
		Assert::false((new Validation\NegateRule($rule))->satisfied($subject));
		Assert::exception(static function() use ($rule, $subject): void {
			(new Validation\NegateRule($rule))->apply($subject);
		}, \UnexpectedValueException::class, 'The rule is not applicable');
	}

	public function testNegateRefusedRule(): void {
		[$rule, $subject] = [new Validation\FakeRule(false), 'abc'];
		Assert::true((new Validation\NegateRule($rule))->satisfied($subject));
		Assert::same($subject, (new Validation\NegateRule($rule))->apply($subject));
	}
}


(new NegateRule())->run();
