<?php
declare(strict_types = 1);

namespace Klapuch\Validation;

/**
 * Negation of the origin rule
 */
final class NegateRule implements Rule {
	/** @var \Klapuch\Validation\Rule */
	private $origin;

	public function __construct(Rule $origin) {
		$this->origin = $origin;
	}

	/**
	 * @param mixed $subject
	 * @return bool
	 */
	public function satisfied($subject): bool {
		return !$this->origin->satisfied($subject);
	}

	/**
	 * @param mixed $subject
	 * @return mixed
	 */
	public function apply($subject) {
		if (!$this->satisfied($subject))
			throw new \UnexpectedValueException('The rule is not applicable');
		return $subject;
	}
}
