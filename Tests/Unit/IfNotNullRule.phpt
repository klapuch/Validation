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

/**
 * @testCase
 */
final class IfNotNullRule extends Tester\TestCase {
	public function testIgnoredRuleForNullSubject(): void {
		$rule = new Validation\FakeRule(false, new \DomainException('foo'));
		Assert::true((new Validation\IfNotNullRule($rule))->satisfied(null));
		Assert::null((new Validation\IfNotNullRule($rule))->apply(null));
	}

	public function testUsingRuleForNotNull(): void {
		$rule = new Validation\FakeRule(false, new \DomainException('foo'));
		Assert::false((new Validation\IfNotNullRule($rule))->satisfied('X'));
		Assert::exception(static function() use ($rule): void {
			(new Validation\IfNotNullRule($rule))->apply('X');
		}, \DomainException::class, 'foo');
	}
}

(new IfNotNullRule())->run();
