<?php
declare(strict_types = 1);
namespace Klapuch\Validation;

/**
 * Multiple rules combined together behaving as a single one
 */
final class CombinedRule implements Rule {
	private $origin;

	public function __construct(Rule $origin) {
		$this->origin = $origin;
	}

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