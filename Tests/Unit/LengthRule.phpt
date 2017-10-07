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

final class LengthRule extends Tester\TestCase {
	public function testStringLengthWithoutSpecialChars() {
		list($length, $subject) = [5, 'hello'];
		Assert::true((new Validation\LengthRule($length))->satisfied($subject));
		Assert::same($subject, (new Validation\LengthRule($length))->apply($subject));
	}

	public function testStringLengthWithSpecialCharacters() {
		Assert::true((new Validation\LengthRule(6))->satisfied('kůň<@>'));
	}

	public function testEmptyString() {
		Assert::true((new Validation\LengthRule(0))->satisfied(''));
	}

	public function testInvalidMatch() {
		list($length, $subject) = [-1, 'foo'];
		Assert::false((new Validation\LengthRule($length))->satisfied($subject));
		Assert::exception(
			function() use ($length, $subject) {
				(new Validation\LengthRule($length))->apply($subject);
			},
			\UnexpectedValueException::class,
			'Subject is not -1 characters long'
		);
	}
}


(new LengthRule())->run();