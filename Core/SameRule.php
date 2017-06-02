<?php
declare(strict_types = 1);
namespace Klapuch\Validation;

/**
 * Rule using strict data type check
 */
final class SameRule implements Rule {
	private $expectation;

	public function __construct($expectation) {
		$this->expectation = $expectation;
	}

	public function satisfied($subject): bool {
		return $this->expectation === $subject;
	}

	public function apply($subject): void {
		if (!$this->satisfied($subject)) {
			throw new \UnexpectedValueException(
				sprintf(
					'"%s" is not same as "%s"',
					$this->expectation,
					$subject
				)
			);
		}
	}
}