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

/**
 * @testCase
 */
final class DateTimeRuleTest extends Tester\TestCase {
	public function testPassingWithIso8601(): void {
		Assert::true((new Validation\DateTimeRule())->satisfied('2017-09-17T13:58:10+00:00'));
		Assert::noError(static function(): void {
			(new Validation\DateTimeRule())->apply('2017-09-17T13:58:10+00:00');
		});
	}

	public function testPassingWithJavascriptPreferredIso8601(): void {
		Assert::true((new Validation\DateTimeRule())->satisfied('2018-05-27T19:14:02.232+02:00'));
		Assert::noError(static function(): void {
			(new Validation\DateTimeRule())->apply('2018-05-27T19:14:02.232+02:00');
		});
	}

	public function testFailingOnCustomFormat(): void {
		Assert::false((new Validation\DateTimeRule())->satisfied('2017-09-17 13:58:10'));
		Assert::exception(static function(): void {
			(new Validation\DateTimeRule())->apply('2017-09-17 13:58:10');
		}, \UnexpectedValueException::class, 'Datetime must be in ISO8601');
	}

	public function testNoModification(): void {
		Assert::same(
			'2017-09-17T13:58:10+00:00',
			(new Validation\DateTimeRule())->apply('2017-09-17T13:58:10+00:00')
		);
	}
}

(new DateTimeRuleTest())->run();
