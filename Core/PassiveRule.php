<?php
declare(strict_types = 1);

namespace Klapuch\Validation;

/**
 * Passive rule serves as a null object
 */
final class PassiveRule implements Rule {
	/**
	 * @param mixed $subject
	 * @return bool
	 */
	public function satisfied($subject): bool {
		return true;
	}

	/**
	 * @param mixed $subject
	 * @return mixed
	 */
	public function apply($subject) {
		return $subject;
	}
}
