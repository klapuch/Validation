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

final class LengthRule extends Tester\TestCase {
	public function testStringLengthWithoutSpecialChars() {
		Assert::true((new Validation\LengthRule(5))->satisfied('hello'));
	}

	public function testStringLengthWithSpecialCharacters() {
		Assert::true((new Validation\LengthRule(6))->satisfied('kůň<@>'));
	}

	public function testEmptyString() {
		Assert::true((new Validation\LengthRule(0))->satisfied(''));
	}

	public function testInvalidMatch() {
		Assert::false((new Validation\LengthRule(-1))->satisfied('foo'));
	}
}


(new LengthRule())->run();
