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
final class IntervalDiffRuleTest extends Tester\TestCase {
	public function testAllowingInRange(): void {
		Assert::true((new Validation\IntervalDiffRule('PT20H'))->satisfied('PT10H'));
		Assert::noError(static function(): void {
			(new Validation\IntervalDiffRule('PT20H'))->apply('PT10H');
		});
	}

	public function testAllowingSameAsMax(): void {
		Assert::true((new Validation\IntervalDiffRule('PT20H'))->satisfied('PT20H'));
	}

	public function testThrowingOutOfMax(): void {
		Assert::false((new Validation\IntervalDiffRule('PT20H'))->satisfied('P1D'));
		Assert::exception(static function(): void {
			(new Validation\IntervalDiffRule('PT20H'))->apply('P1D');
		}, \UnexpectedValueException::class, 'Max diff is "PT20H", given "P1D"');
	}
}

(new IntervalDiffRuleTest())->run();
