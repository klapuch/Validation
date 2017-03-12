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

final class PassiveRule extends Tester\TestCase {
	public function testSatisfyingAll() {
		Assert::true((new Validation\PassiveRule())->satisfied('a'));
		Assert::true((new Validation\PassiveRule())->satisfied(1));
		Assert::true((new Validation\PassiveRule())->satisfied(null));
		Assert::true((new Validation\PassiveRule())->satisfied(false));
	}

	public function testAllowingAllAplications() {
		Assert::noError(function() {
			(new Validation\PassiveRule())->apply('a');
			(new Validation\PassiveRule())->apply(1);
			(new Validation\PassiveRule())->apply(null);
			(new Validation\PassiveRule())->apply(false);
		});
	}
}


(new PassiveRule())->run();