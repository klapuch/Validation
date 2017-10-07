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
		return in_array(
			$subject,
			range($this->min, $this->max),
			$this->restricted($subject)
		);
	}

	/**
	 * Is it necessary to restrict the type?
	 * @param mixed $subject
	 * @return bool
	 */
	private function restricted($subject): bool {
		return !is_numeric($this->min)
			|| !is_numeric($this->max)
			|| !is_numeric($subject);
	}

	/**
	 * @param mixed $subject
	 * @return int|string
	 */
	public function apply($subject) {
		if (!$this->satisfied($subject)) {
			throw new \UnexpectedValueException(
				sprintf(
					'Subject is not in the allowed range from "%s" to "%s"',
					min($this->min, $this->max),
					max($this->min, $this->max)
				)
			);
		}
		return $subject;
	}
}