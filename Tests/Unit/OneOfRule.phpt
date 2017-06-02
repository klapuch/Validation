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

final class OneOfRule extends Tester\TestCase {
	public function testMatchingWithingSameType() {
		Assert::true((new Validation\OneOfRule(['a', 'b']))->satisfied('a'));
		Assert::true((new Validation\OneOfRule(['a', 'b']))->satisfied('b'));
		Assert::false((new Validation\OneOfRule(['A', 'B']))->satisfied('a'));
		Assert::false((new Validation\OneOfRule(['a', 'b']))->satisfied(['a']));
	}

	public function testEmptySetMeaningNothingAllowed() {
		Assert::false((new Validation\OneOfRule([]))->satisfied('a'));
		Assert::false((new Validation\OneOfRule([]))->satisfied(''));
		Assert::false((new Validation\OneOfRule([]))->satisfied([]));
	}

	public function testStrictTypeChecking() {
		Assert::false((new Validation\OneOfRule([true, 'b']))->satisfied('1'));
		Assert::false((new Validation\OneOfRule(['1', 'b']))->satisfied(true));
	}
	public function testApplicationMessages() {
		Assert::noError(function() {
			(new Validation\OneOfRule([1, 2]))->apply(1);
		});
		Assert::exception(function() {
			(new Validation\OneOfRule(['a', 'b', 1]))->apply('Hello');
		}, \UnexpectedValueException::class, '"a", "b", "1" set do not contain "Hello" as type string');
		Assert::exception(function() {
			(new Validation\OneOfRule(['a', 'b', '1']))->apply(1);
		}, \UnexpectedValueException::class, '"a", "b", "1" set do not contain "1" as type integer');
	}
}


(new OneOfRule())->run();