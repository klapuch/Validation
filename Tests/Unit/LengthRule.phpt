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
	public function testStringLengthWithoutSpecialChars(): void {
		[$length, $subject] = [5, 'hello'];
		Assert::true((new Validation\LengthRule($length))->satisfied($subject));
		Assert::same($subject, (new Validation\LengthRule($length))->apply($subject));
	}

	public function testStringLengthWithSpecialCharacters(): void {
		Assert::true((new Validation\LengthRule(6))->satisfied('kůň<@>'));
	}

	public function testEmptyString(): void {
		Assert::true((new Validation\LengthRule(0))->satisfied(''));
	}

	public function testInvalidMatch(): void {
		[$length, $subject] = [-1, 'foo'];
		Assert::false((new Validation\LengthRule($length))->satisfied($subject));
		Assert::exception(
			static function() use ($length, $subject): void {
				(new Validation\LengthRule($length))->apply($subject);
			},
			\UnexpectedValueException::class,
			'Subject is not -1 characters long'
		);
	}
}


(new LengthRule())->run();
