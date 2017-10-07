<?php
declare(strict_types = 1);
namespace Klapuch\Validation;

/**
 * Rule for satisfying email subject
 */
final class EmailRule implements Rule {
	public function satisfied($subject): bool {
		return (bool) filter_var($subject, FILTER_VALIDATE_EMAIL);
	}

	/**
	 * @param mixed $subject
	 * @return string
	 */
	public function apply($subject): string {
		if (!$this->satisfied($subject))
			throw new \UnexpectedValueException('Subject is not an email');
		return $subject;
	}
}