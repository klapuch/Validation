<?php
declare(strict_types = 1);
namespace Klapuch\Validation;

/**
 * Multiple rules
 */
abstract class Rules implements Rule {
	protected $rules;

	final public function __construct(Rule ...$rules) {
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
}