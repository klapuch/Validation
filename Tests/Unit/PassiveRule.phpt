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

final class PassiveRule extends Tester\TestCase {
	public function testSatisfyingAll(): void {
		Assert::true((new Validation\PassiveRule())->satisfied('a'));
		Assert::true((new Validation\PassiveRule())->satisfied(1));
		Assert::true((new Validation\PassiveRule())->satisfied(null));
		Assert::true((new Validation\PassiveRule())->satisfied(false));
	}

	public function testAllowingAllApplications(): void {
		Assert::same('a', (new Validation\PassiveRule())->apply('a'));
		Assert::same(1, (new Validation\PassiveRule())->apply(1));
		Assert::same(null, (new Validation\PassiveRule())->apply(null));
		Assert::same(false, (new Validation\PassiveRule())->apply(false));
	}
}


(new PassiveRule())->run();
