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

final class IdleRule extends Tester\TestCase {
	public function testSatisfyingAll() {
		Assert::true((new Validation\IdleRule())->satisfied('a'));
		Assert::true((new Validation\IdleRule())->satisfied(1));
		Assert::true((new Validation\IdleRule())->satisfied(null));
		Assert::true((new Validation\IdleRule())->satisfied(false));
	}

	public function testAllowingAllAplications() {
		Assert::noError(function() {
			(new Validation\IdleRule())->apply('a');
			(new Validation\IdleRule())->apply(1);
			(new Validation\IdleRule())->apply(null);
			(new Validation\IdleRule())->apply(false);
		});
	}
}


(new IdleRule())->run();