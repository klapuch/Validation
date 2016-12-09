<?php
declare(strict_types = 1);
namespace Klapuch\Validation;

/**
 * Multiple rules combined together
 */
final class CombinedRule implements Rule {
	private $rules;

	public function __construct(Rule ...$rules) {
		$this->rules = $rules;
	}

	public function satisfied($subject): bool {
		return array_filter(
			$this->rules,
			function(Rule $rule) use($subject): bool {
				return $rule->satisfied($subject) === true;
			}
		) === $this->rules;
	}

	public function apply($subject): void {
		if(!$this->satisfied($subject))
			throw new \UnexpectedValueException('The rule is not applicable');
	}
}