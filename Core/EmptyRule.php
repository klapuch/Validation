<?php
declare(strict_types = 1);
namespace Klapuch\Validation;

/**
 * Rule for satisfying empty subject
 */
final class EmptyRule implements Rule {
	public function satisfied($subject): bool {
		return $this->isArray($subject)
			? !$subject || array_filter($subject, [$this, 'satisfied'])
			: !strlen(trim((string)$subject));
	}

	/**
	 * Is the given subject an array?
	 * Faster version of is_array - because of recursion
	 * @param mixed $subject
	 * @return bool
	 */
	private function isArray($subject): bool {
		return (array)$subject === $subject;
	}
}
