<?php
declare(strict_types = 1);
namespace Klapuch\Validation;

/**
 * Negation of the origin rule
 */
final class NegateRule implements Rule {
	private $origin;

	public function __construct(Rule $origin) {
		$this->origin = $origin;
	}

	public function satisfied($subject): bool {
		return !$this->origin->satisfied($subject);
	}

	public function apply($subject): void {
		if (!$this->satisfied($subject))
			throw new \UnexpectedValueException('The rule is not applicable');
	}
}