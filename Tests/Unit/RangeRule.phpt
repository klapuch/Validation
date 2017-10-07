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

final class RangeRule extends Tester\TestCase {
	public function testSatisfyingRange() {
		list($from, $to, $subject) = [6, 9, 7];
		Assert::true((new Validation\RangeRule($from, $to))->satisfied($subject));
		Assert::same($subject, (new Validation\RangeRule($from, $to))->apply($subject));
	}

	public function testOutOfRange() {
		list($from, $to, $subject) = [6, 9, 10];
		Assert::false((new Validation\RangeRule($from, $to))->satisfied($subject));
		Assert::exception(
			function() use ($from, $to, $subject) {
				(new Validation\RangeRule($from, $to))->apply($subject);
			},
			\UnexpectedValueException::class,
			'Subject is not in the allowed range from "6" to "9"'
		);
	}

	public function testFlippedFromTo() {
		Assert::true((new Validation\RangeRule(9, 6))->satisfied(7));
	}

	public function testFlippedFromToDuringApplying() {
		Assert::exception(
			function() {
				(new Validation\RangeRule(9, 6))->apply(1);
			},
			\UnexpectedValueException::class,
			'Subject is not in the allowed range from "6" to "9"'
		);
		Assert::exception(
			function() {
				(new Validation\RangeRule('s', 'c'))->apply('a');
			},
			\UnexpectedValueException::class,
			'Subject is not in the allowed range from "c" to "s"'
		);
	}

	public function testEdges() {
		Assert::true((new Validation\RangeRule(9, 6))->satisfied(6));
		Assert::true((new Validation\RangeRule(9, 6))->satisfied(9));
	}

	public function testSameMinMax() {
		Assert::false((new Validation\RangeRule(9, 9))->satisfied(6));
		Assert::true((new Validation\RangeRule(9, 9))->satisfied(9));
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
		Assert::false((new Validation\RangeRule(1, 9))->satisfied(null));
		Assert::false((new Validation\RangeRule(1, 9))->satisfied(0));
	}

	public function testEmptySubjectForLetters() {
		Assert::false((new Validation\RangeRule('a', 'z'))->satisfied(''));
		Assert::false((new Validation\RangeRule('a', 'z'))->satisfied(false));
		Assert::false((new Validation\RangeRule('a', 'z'))->satisfied(null));
		Assert::false((new Validation\RangeRule('a', 'z'))->satisfied(0));
	}

	public function testIgnoringType() {
		Assert::true((new Validation\RangeRule(1, 30))->satisfied('20'));
		Assert::true((new Validation\RangeRule('1', '30'))->satisfied(20));
		Assert::true((new Validation\RangeRule('1', 30))->satisfied('20'));
		Assert::true((new Validation\RangeRule(1, '30'))->satisfied('20'));
		Assert::true((new Validation\RangeRule('1', 30))->satisfied(20));
		Assert::true((new Validation\RangeRule(1, '30'))->satisfied(20));
		Assert::false((new Validation\RangeRule('a', 'z'))->satisfied(1));
		Assert::false((new Validation\RangeRule(1, 1000))->satisfied('a'));
	}
}


(new RangeRule())->run();