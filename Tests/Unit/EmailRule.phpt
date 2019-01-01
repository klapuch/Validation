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

final class EmailRule extends Tester\TestCase {
	/**
	 * @dataProvider validEmails
	 */
	public function testValidEmails($subject): void {
		Assert::true((new Validation\EmailRule())->satisfied($subject));
		Assert::same($subject, (new Validation\EmailRule())->apply($subject));
	}

	/**
	 * @dataProvider invalidEmails
	 */
	public function testInvalidEmails($subject): void {
		$rule = new Validation\EmailRule();
		Assert::false($rule->satisfied($subject));
		Assert::exception(static function() use ($rule, $subject): void {
			$rule->apply($subject);
		}, \UnexpectedValueException::class, 'Subject is not an email');
	}

	protected function validEmails() {
		return [
			['foo@gmail.com'],
			['foo.bar@gmail.com'],
			['foo@gmail.c'],
		];
	}

	protected function invalidEmails() {
		return [
			[''],
			['  '],
			['foo'],
			[1],
			[false],
			[null],
			['foo@@gmail.com'],
			['foo@gmail..com'],
		];
	}
}


(new EmailRule())->run();
