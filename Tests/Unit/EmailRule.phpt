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

final class EmailRule extends Tester\TestCase {
	/**
	 * @dataProvider validEmails
	 */
	public function testValidEmails($subject) {
		$rule = new Validation\EmailRule();
		Assert::true($rule->satisfied($subject));
		Assert::noError(function() use($rule, $subject) {
			$rule->apply($subject);
		});
	}

	/**
	 * @dataProvider invalidEmails
	 */
	public function testInvalidEmails($subject) {
		$rule = new Validation\EmailRule();
		Assert::false($rule->satisfied($subject));
		Assert::exception(function() use($rule, $subject) {
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