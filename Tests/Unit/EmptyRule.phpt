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
	public function testEntirelyEmptySubject(): void {
		Assert::true((new Validation\EmptyRule())->satisfied(''));
		Assert::true((new Validation\EmptyRule())->satisfied(null));
		Assert::true((new Validation\EmptyRule())->satisfied([]));
		Assert::true((new Validation\EmptyRule())->satisfied([[''], ['']]));
		Assert::true((new Validation\EmptyRule())->satisfied([[], []]));
	}

	public function testPartiallyEmptySubject(): void {
		Assert::false((new Validation\EmptyRule())->satisfied(['a', '']));
		Assert::false((new Validation\EmptyRule())->satisfied(['', 'a']));
		Assert::false((new Validation\EmptyRule())->satisfied([[''], 'a']));
		Assert::false((new Validation\EmptyRule())->satisfied(['a', ['']]));
	}

	public function testComparableEmptySubject(): void {
		Assert::false((new Validation\EmptyRule())->satisfied(['false', 'false']));
		Assert::true((new Validation\EmptyRule())->satisfied([false, false]));
		Assert::true((new Validation\EmptyRule())->satisfied(false));
		Assert::false((new Validation\EmptyRule())->satisfied('false'));
		Assert::false((new Validation\EmptyRule())->satisfied(0e123));
		Assert::false((new Validation\EmptyRule())->satisfied('0e123'));
		Assert::false((new Validation\EmptyRule())->satisfied(0));
		Assert::false((new Validation\EmptyRule())->satisfied('0'));
	}

	public function testSpacyEmptySubject(): void {
		Assert::false((new Validation\EmptyRule())->satisfied('    0'));
		Assert::false((new Validation\EmptyRule())->satisfied('0    '));
		Assert::true((new Validation\EmptyRule())->satisfied(' '));
		Assert::true((new Validation\EmptyRule())->satisfied('    '));
		Assert::true((new Validation\EmptyRule())->satisfied(['  ', '  ']));
		Assert::true((new Validation\EmptyRule())->satisfied([[' '], [' ']]));
		Assert::true((new Validation\EmptyRule())->satisfied([['   '], ['   ']]));
	}

	public function testFullyFilledSubject(): void {
		Assert::false((new Validation\EmptyRule())->satisfied([0, 0]));
		Assert::false((new Validation\EmptyRule())->satisfied(['a', 'b']));
		Assert::false((new Validation\EmptyRule())->satisfied([['a'], ['b']]));
	}

	public function testSimplyFilledSubject(): void {
		Assert::false((new Validation\EmptyRule())->satisfied(true));
		Assert::false((new Validation\EmptyRule())->satisfied('true'));
		Assert::false((new Validation\EmptyRule())->satisfied(-1));
		Assert::false((new Validation\EmptyRule())->satisfied(1));
		Assert::false((new Validation\EmptyRule())->satisfied(6));
	}

	public function testApplications(): void {
		Assert::same('', (new Validation\EmptyRule())->apply(''));
		Assert::exception(static function(): void {
			(new Validation\EmptyRule())->apply('foo');
		}, \UnexpectedValueException::class, 'Subject is not empty');
	}

}


(new EmptyRule())->run();
