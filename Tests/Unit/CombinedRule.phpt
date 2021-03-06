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

final class CombinedRule extends Tester\TestCase {
	public function testAllSatisfiedRules(): void {
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

	public function testNoneSatisfiedRule(): void {
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

	public function testSomeSatisfiedRule(): void {
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

	public function testApplications(): void {
		Assert::same(
			'abc',
			(new Validation\CombinedRule(
				new Validation\FakeRule(true)
			))->apply('abc')
		);
		Assert::exception(static function(): void {
			(new Validation\CombinedRule(
				new Validation\FakeRule(false)
			))->apply('abc');
		}, \UnexpectedValueException::class, 'The rule is not applicable');
	}
}


(new CombinedRule())->run();
