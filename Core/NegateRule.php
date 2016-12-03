<?php
declare(strict_types = 1);
namespace Klapuch\Validation;

/**
 * Rule for negation origin rule
 */
final class NegateRule implements Rule {
	private $origin;

	public function __construct(Rule $origin) {
		$this->origin = $origin;
	}

	public function satisfied($subject): bool {
		return !$this->origin->satisfied($subject);
	}
}
