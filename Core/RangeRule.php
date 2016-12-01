<?php
declare(strict_types = 1);
namespace Klapuch\Validation;

/**
 * Rule for satisfying subject in allowed range
 */
final class RangeRule implements Rule {
	private $from;
	private $to;

	/**
	 * @param int|string $from
	 * @param int|string $to
	 */
	public function __construct($from, $to) {
		$this->from = $from;
		$this->to = $to;
	}

	public function satisfied($subject): bool {
		return in_array($subject, range($this->from(), $this->to()), true);
	}

	/**
	 * The real top border from the range
	 * @return int|string
	 */
	private function from() {
		return max($this->from, $this->to);
	}

	/**
	 * The real bottom border from the range
	 * @return int|string
	 */
	private function to() {
		return min($this->from, $this->to);
	}
}
