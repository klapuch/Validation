<?php
declare(strict_types = 1);
namespace Klapuch\Validation\TestCase;

use Tester;

abstract class Mockery extends Tester\TestCase {
	final protected function mock($class) {
		return \Mockery::mock($class);
	}

	protected function tearDown() {
		parent::tearDown();
		\Mockery::close();
	}
}
