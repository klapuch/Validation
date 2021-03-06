<?php
declare(strict_types = 1);

namespace Klapuch\Validation;

/**
 * Multiple rules combined together behaving as a single one
 */
final class CombinedRule implements Rule {
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
		return $this->origin->satisfied($subject);
	}

	/**
	 * @param mixed $subject
	 * @return mixed
	 */
	public function apply($subject) {
		if (!$this->origin->satisfied($subject))
			throw new \UnexpectedValueException('The rule is not applicable');
		return $subject;
	}
}
