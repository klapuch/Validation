<?php
declare(strict_types = 1);
namespace Klapuch\Validation;

/**
 * Rule for satisfying numeric characters
 */
final class NumericRule implements Rule {
	public function satisfied($subject): bool {
		return $this->numeric($subject) && $this->inRange($subject);
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
	 * Is the number in allowable range? No E or infinitiv?
	 * @param float|int|string $subject
	 * @return bool
	 */
	private function inRange($subject): bool {
		return stripos((string)$subject, 'e') === false
			&& stripos((string)$subject, 'INF') === false;
	}
}

