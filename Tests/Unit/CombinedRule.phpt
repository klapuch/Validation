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

final class CombinedRule extends Tester\TestCase {
	public function testAllSatisfiedRules() {
		Assert::true(
			(new Validation\CombinedRule(
				new Validation\ChainedRule(
					new Validation\FakeRule(true),
					new Validation\FakeRule(true),
					new Validation\FakeRule(true)
				)
			))->satisfied('abc')
		);
	}

	public function testNoneSatisfiedRule() {
		Assert::false(
			(new Validation\CombinedRule(
				new Validation\ChainedRule(
					new Validation\FakeRule(false),
					new Validation\FakeRule(false),
					new Validation\FakeRule(false)
				)
			))->satisfied('abc')
		);
	}

	public function testSomeSatisfiedRule() {
		Assert::false(
			(new Validation\CombinedRule(
				new Validation\ChainedRule(
					new Validation\FakeRule(true),
					new Validation\FakeRule(false),
					new Validation\FakeRule(true)
				)
			))->satisfied('abc')
		);
	}

	public function testApplications() {
		Assert::noError(function() {
			(new Validation\CombinedRule(
				new Validation\FakeRule(true)
			))->apply('abc');
		});
		Assert::exception(function() {
			(new Validation\CombinedRule(
				new Validation\FakeRule(false)
			))->apply('abc');
		}, \UnexpectedValueException::class, 'The rule is not applicable');
	}
}


(new CombinedRule())->run();