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
final class IntervalRuleTest extends Tester\TestCase {
	public function testPassingWithIso8601(): void {
		Assert::true((new Validation\IntervalRule())->satisfied('PT10H'));
		Assert::noError(static function(): void {
			(new Validation\IntervalRule())->apply('PT10H');
		});
	}

	public function testFailingOnCustomFormat(): void {
		Assert::false((new Validation\IntervalRule())->satisfied('PT10Habc'));
		Assert::exception(static function(): void {
			(new Validation\IntervalRule())->apply('PT10Habc');
		}, \UnexpectedValueException::class, 'Interval must be in ISO8601');
	}

	public function testNoModification(): void {
		Assert::same('PT10H', (new Validation\IntervalRule())->apply('PT10H'));
	}
}

(new IntervalRuleTest())->run();
