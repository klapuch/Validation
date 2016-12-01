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

final class EmptyRule extends Tester\TestCase {
	/**
	 * @dataProvider voids
	 */
	public function testVoids($void) {
		Assert::true((new Validation\EmptyRule())->satisfied($void));
	}

	/**
	 * @dataProvider fills
	 */
	public function testFills($fill) {
		Assert::false((new Validation\EmptyRule())->satisfied($fill));
	}

	protected function voids(): iterable {
		return [
			[''],
			[' '],
			[null],
			[false],
			['    '],
			[[]],
			[['', '']],
			[[[], []]],
			[['  ', '  ']],
			[[[' '], [' ']]],
		];
	}

	protected function fills(): iterable {
		return [
			[0],
			[true],
			['true'],
			['false'],
			[-1],
			[1],
			['    0'],
			[[0, 0]],
			[['a', 'b']],
			[['b', '']],
			[['', 'b']],
			[['', ['a']]],
			[[['a'], '']],
		];
	}
}


(new EmptyRule())->run();
