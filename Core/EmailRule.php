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

	public function apply($subject): void {
		if (!$this->satisfied($subject))
			throw new \UnexpectedValueException('Subject is not an email');
	}
}