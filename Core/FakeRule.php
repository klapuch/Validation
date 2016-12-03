<?php
declare(strict_types = 1);
namespace Klapuch\Validation;

/**
 * Fake
 */
final class FakeRule implements Rule {
	private $satisfied;

	public function __construct(bool $satisfied = null) {
		$this->satisfied = $satisfied;
	}

	public function satisfied($subject): bool {
		return $this->satisfied;
	}
}
