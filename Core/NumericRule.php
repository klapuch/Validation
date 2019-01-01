<?php
declare(strict_types = 1);

namespace Klapuch\Validation;

/**
 * Rule for satisfying numeric characters
 */
final class NumericRule implements Rule {
	/**
	 * @param mixed $subject
	 * @return bool
	 */
	public function satisfied($subject): bool {
		return $this->numeric($subject) && $this->inRange($subject);
	}

	/**
	 * @param mixed $subject
	 * @return int|float|string
	 */
	public function apply($subject) {
		if (!$this->satisfied($subject))
			throw new \UnexpectedValueException('Subject is not numeric');
		return $subject;
	}

	/**
	 * Can be the subject considered as a numeric value and used for further check?
	 * @param mixed $subject
	 * @return bool
	 */
	private function numeric($subject): bool {
		return is_float($subject)
			|| is_int($subject)
			|| is_string($subject)
			&& is_numeric($subject);
	}

	/**
	 * Is the number in allowable range? No E or infinitive?
	 * @param float|int|string $subject
	 * @return bool
	 */
	private function inRange($subject): bool {
		return stripos((string) $subject, 'e') === false
			&& stripos((string) $subject, 'INF') === false;
	}
}
