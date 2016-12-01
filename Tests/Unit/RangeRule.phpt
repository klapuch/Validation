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

final class RangeRule extends Tester\TestCase {
	public function testSatisfyingRange() {
		Assert::true((new Validation\RangeRule(6, 9))->satisfied(7));
	}

	public function testOutOfRange() {
		Assert::false((new Validation\RangeRule(6, 9))->satisfied(10));
	}

	public function testFlippedFromTo() {
		Assert::true((new Validation\RangeRule(9, 6))->satisfied(7));
	}

	public function testEdges() {
		Assert::true((new Validation\RangeRule(9, 6))->satisfied(6));
		Assert::true((new Validation\RangeRule(9, 6))->satisfied(9));
	}

	public function testSameFromTo() {
		Assert::false((new Validation\RangeRule(9, 9))->satisfied(6));
		Assert::true((new Validation\RangeRule(9, 9))->satisfied(9));
	}

	public function testTypeSafeRange() {
		Assert::false((new Validation\RangeRule(6, 9))->satisfied('7'));
	}

	public function testMixingNumbersWithLetters() {
		Assert::false((new Validation\RangeRule(6, 9))->satisfied('h'));
		Assert::false((new Validation\RangeRule('f', 'j'))->satisfied(7));
	}

	public function testSatisfyingAlphabetRange() {
		Assert::true((new Validation\RangeRule('a', 'z'))->satisfied('f'));
	}

	public function testFlippedAlphabetRange() {
		Assert::true((new Validation\RangeRule('z', 'a'))->satisfied('f'));
	}

	public function testEmptySubjectForNumbers() {
		Assert::false((new Validation\RangeRule(1, 9))->satisfied(''));
		Assert::false((new Validation\RangeRule(1, 9))->satisfied(false));
		Assert::false((new Validation\RangeRule(1, 9))->satisfied(NULL));
		Assert::false((new Validation\RangeRule(1, 9))->satisfied(0));
	}

	public function testEmptySubjectForLetters() {
		Assert::false((new Validation\RangeRule('a', 'z'))->satisfied(''));
		Assert::false((new Validation\RangeRule('a', 'z'))->satisfied(false));
		Assert::false((new Validation\RangeRule('a', 'z'))->satisfied(NULL));
		Assert::false((new Validation\RangeRule('a', 'z'))->satisfied(0));
	}
}


(new RangeRule())->run();
