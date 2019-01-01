<?php
declare(strict_types = 1);

namespace Klapuch\Validation;

/**
 * Rule using strict data type check
 */
final class SameRule implements Rule {
	/** @var mixed */
	private $expectation;

	/**
	 * @param mixed $expectation
	 */
	public function __construct($expectation) {
		$this->expectation = $expectation;
	}

	/**
	 * @param mixed $subject
	 * @return bool
	 */
	public function satisfied($subject): bool {
		return $this->expectation === $subject;
	}

	/**
	 * @param mixed $subject
	 * @return mixed
	 */
	public function apply($subject) {
		if (!$this->satisfied($subject)) {
			throw new \UnexpectedValueException(
				sprintf(
					'"%s" is not same as "%s"',
					$this->expectation,
					$subject
				)
			);
		}
		return $subject;
	}
}
