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

final class ChainedRule extends Tester\TestCase {
	public function testAllSatisfiedRules(): void {
		Assert::true(
			(new Validation\ChainedRule(
				new Validation\FakeRule(true),
				new Validation\FakeRule(true),
				new Validation\FakeRule(true)
			))->satisfied('abc')
		);
	}

	public function testNoneSatisfiedRule(): void {
		Assert::false(
			(new Validation\ChainedRule(
				new Validation\FakeRule(false),
				new Validation\FakeRule(false),
				new Validation\FakeRule(false)
			))->satisfied('abc')
		);
	}

	public function testSomeSatisfiedRule(): void {
		Assert::false(
			(new Validation\ChainedRule(
				new Validation\FakeRule(true),
				new Validation\FakeRule(false),
				new Validation\FakeRule(true)
			))->satisfied('abc')
		);
	}

	public function testApplicationsInGivenOrder(): void {
		Assert::same(
			'abc',
			(new Validation\ChainedRule(
				new Validation\FakeRule(null)
			))->apply('abc')
		);
		Assert::exception(static function(): void {
			(new Validation\ChainedRule(
				new Validation\FakeRule(null),
				new Validation\FakeRule(null),
				new Validation\FakeRule(null),
				new Validation\FakeRule(null, new \DomainException('foo')),
				new Validation\FakeRule(null, new \LogicException('bar'))
			))->apply('abc');
		}, \DomainException::class, 'foo');
	}

	public function testSubsequentApplication(): void {
		Assert::same(
			'ABCd',
			(new Validation\ChainedRule(
				new class implements Validation\Rule {
					public function satisfied($subject): bool {
					}

					public function apply($subject) {
						return strtoupper($subject);
					}
				},
				new Validation\FakeRule(null),
				new class implements Validation\Rule {
					public function satisfied($subject): bool {
					}

					public function apply($subject) {
						return $subject . 'd';
					}
				}
			))->apply('abc')
		);
	}
}


(new ChainedRule())->run();
