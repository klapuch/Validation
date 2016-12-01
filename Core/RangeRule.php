<?php
declare(strict_types = 1);
namespace Klapuch\Validation;

/**
 * Rule for satisfying subject in allowed range
 */
final class RangeRule implements Rule {
	private $min;
	private $max;

	/**
	 * @param int|string $min
	 * @param int|string $max
	 */
	public function __construct($min, $max) {
		$this->min = $min;
		$this->max = $max;
	}

	public function satisfied($subject): bool {
		return in_array($subject, range($this->min(), $this->max()), true);
	}

	/**
	 * The real top border from the range
	 * @return int|string
	 */
	private function min() {
		return max($this->min, $this->max);
	}

	/**
	 * The real bottom border from the range
	 * @return int|string
	 */
	private function max() {
		return min($this->min, $this->max);
	}
}
