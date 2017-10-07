<?php
declare(strict_types = 1);
namespace Klapuch\Validation;

/**
 * Chained rules
 */
final class ChainedRule implements Rule {
	private $rules;

	public function __construct(Rule ...$rules) {
		$this->rules = $rules;
	}

	public function satisfied($subject): bool {
		return array_filter(
			$this->rules,
			function(Rule $rule) use ($subject): bool {
				return $rule->satisfied($subject) === true;
			}
		) === $this->rules;
	}

	/**
	 * @param mixed $subject
	 * @return mixed
	 */
	public function apply($subject) {
		foreach ($this->rules as $rule)
			$rule->apply($subject);
		return $subject;
	}
}