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

final class FriendlyRule extends Tester\TestCase {
	public function testNoErrorForUsingFriendlyMessage() {
		Assert::same(
			'abc',
			(new Validation\FriendlyRule(
				new Validation\FakeRule(),
				'foo'
			))->apply('abc')
		);
	}

	public function testErrorForUsingFriendlyMessage() {
		$ex = Assert::exception(function() {
			(new Validation\FriendlyRule(
				new Validation\FakeRule(null, new \DomainException('bar', 666)),
				'foo'
			))->apply('abc');
		}, \UnexpectedValueException::class, 'foo', 666);
		Assert::type(\DomainException::class, $ex->getPrevious());
	}
}


(new FriendlyRule())->run();