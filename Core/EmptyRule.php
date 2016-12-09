<?php
declare(strict_types = 1);
namespace Klapuch\Validation;

/**
 * Rule for satisfying empty subject
 */
final class EmptyRule implements Rule {
	public function satisfied($subject): bool {
		return $this->isArray($subject)
			? array_filter($subject, [$this, 'satisfied']) === $subject
			: !strlen(trim((string)$subject));
	}

	public function apply($subject): void {
		if(!$this->satisfied($subject))
			throw new \UnexpectedValueException('Subject is not empty');
	}

	/**
	 * Is the given subject an array?
	 * Faster version of is_array - because of recursion
	 * @param mixed $subject
	 * @return bool
	 */
	private function isArray($subject): bool {
		return $subject === (array)$subject;
	}
}