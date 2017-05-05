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
	public function testAllSatisfiedRules() {
		Assert::true(
			(new Validation\ChainedRule(
				new Validation\FakeRule(true),
				new Validation\FakeRule(true),
				new Validation\FakeRule(true)
			))->satisfied('abc')
		);
	}

	public function testNoneSatisfiedRule() {
		Assert::false(
			(new Validation\ChainedRule(
				new Validation\FakeRule(false),
				new Validation\FakeRule(false),
				new Validation\FakeRule(false)
			))->satisfied('abc')
		);
	}

	public function testSomeSatisfiedRule() {
		Assert::false(
			(new Validation\ChainedRule(
				new Validation\FakeRule(true),
				new Validation\FakeRule(false),
				new Validation\FakeRule(true)
			))->satisfied('abc')
		);
	}

	public function testApplications() {
		Assert::noError(function() {
			(new Validation\ChainedRule(
				new Validation\FakeRule(null)
			))->apply('abc');
		});
		Assert::exception(function() {
			(new Validation\ChainedRule(
				new Validation\FakeRule(null),
				new Validation\FakeRule(null),
				new Validation\FakeRule(null),
				new Validation\FakeRule(null, new \DomainException('foo')),
				new Validation\FakeRule(null, new \LogicException('bar'))
			))->apply('abc');
		}, \DomainException::class, 'foo');
	}
}


(new ChainedRule())->run();