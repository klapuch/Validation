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

final class EmptyRule extends Tester\TestCase {
	public function testEntirelyEmptySubject() {
		Assert::true((new Validation\EmptyRule())->satisfied(''));
		Assert::true((new Validation\EmptyRule())->satisfied(null));
		Assert::true((new Validation\EmptyRule())->satisfied([]));
		Assert::true((new Validation\EmptyRule())->satisfied([''], ['']));
		Assert::true((new Validation\EmptyRule())->satisfied([[], []]));
	}

	public function testPartiallyEmptySubject() {
		Assert::false((new Validation\EmptyRule())->satisfied(['a', '']));
		Assert::false((new Validation\EmptyRule())->satisfied(['', 'a']));
		Assert::false((new Validation\EmptyRule())->satisfied([[''], 'a']));
		Assert::false((new Validation\EmptyRule())->satisfied(['a', ['']]));
	}

	public function testComparableEmptySubject() {
		Assert::false((new Validation\EmptyRule())->satisfied(['false', 'false']));
		Assert::true((new Validation\EmptyRule())->satisfied([false, false]));
		Assert::true((new Validation\EmptyRule())->satisfied(false));
		Assert::false((new Validation\EmptyRule())->satisfied('false'));
		Assert::false((new Validation\EmptyRule())->satisfied(0e123));
		Assert::false((new Validation\EmptyRule())->satisfied('0e123'));
		Assert::false((new Validation\EmptyRule())->satisfied(0));
		Assert::false((new Validation\EmptyRule())->satisfied('0'));
	}

	public function testSpacyEmptySubject() {
		Assert::false((new Validation\EmptyRule())->satisfied('    0'));
		Assert::false((new Validation\EmptyRule())->satisfied('0    '));
		Assert::true((new Validation\EmptyRule())->satisfied(' '));
		Assert::true((new Validation\EmptyRule())->satisfied('    '));
		Assert::true((new Validation\EmptyRule())->satisfied(['  ', '  ']));
		Assert::true((new Validation\EmptyRule())->satisfied([[' '], [' ']]));
		Assert::true((new Validation\EmptyRule())->satisfied([['   '], ['   ']]));
	}

	public function testFullyFilledSubject() {
		Assert::false((new Validation\EmptyRule())->satisfied([0, 0]));
		Assert::false((new Validation\EmptyRule())->satisfied(['a', 'b']));
		Assert::false((new Validation\EmptyRule())->satisfied([['a'], ['b']]));
	}

	public function testSimplyFilledSubject() {
		Assert::false((new Validation\EmptyRule())->satisfied(true));
		Assert::false((new Validation\EmptyRule())->satisfied('true'));
		Assert::false((new Validation\EmptyRule())->satisfied(-1));
		Assert::false((new Validation\EmptyRule())->satisfied(1));
		Assert::false((new Validation\EmptyRule())->satisfied(6));
	}

	public function testApplications() {
		Assert::noError(function() {
			(new Validation\EmptyRule())->apply('');
		});
		Assert::exception(function() {
			(new Validation\EmptyRule())->apply('foo');
		}, \UnexpectedValueException::class, 'Subject is not empty');
	}

}


(new EmptyRule())->run();